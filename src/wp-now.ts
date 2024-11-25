import { rootCertificates } from 'tls';
import { createNodeFsMountHandler, loadNodeRuntime } from '@php-wasm/node';
import {
    PHP,
    PHPRequestHandler,
    proxyFileSystem,
    rotatePHPRuntime,
    setPhpIniEntries,
    UnmountFunction,
} from '@php-wasm/universal';
import {
    wordPressRewriteRules,
    getFileNotFoundActionForWordPress,
} from '@wp-playground/wordpress';

import { WPNowOptions, WPNowMode } from './config';

import { output } from './output';


function mountWithHandler(
    php: PHP,
    virtualFSPath: string,
    hostPath: string
): Promise<UnmountFunction> {
    // Must ensure target exists for both folder *and* file
    php.mkdir(virtualFSPath);
    return php.mount(virtualFSPath, createNodeFsMountHandler(hostPath));
}

export default async function startWPNow(
    options: Partial<WPNowOptions> = {}
): Promise<{ php: PHP; options: WPNowOptions }> {
    const { documentRoot } = options;

    const requestHandler = new PHPRequestHandler({
        phpFactory: async ({ isPrimary, requestHandler }) => {
            const { php } = await getPHPInstance(options);

            if (requestHandler) {
                php.requestHandler = requestHandler;
            }
            if (isPrimary) {
                /**
                 * @TODO: Mount /internal/shared/mu-plugins instead of altering
                 * the installed WordPress site. Refer to @wp-playground/wordpress.
                 * https://github.com/WordPress/wordpress-playground/blob/19e64f5782631e94ffeb6dd2e552c3868c6dc29d/packages/playground/wordpress/src/boot.ts#L127-L143
                 */
            } else {
                // Proxy the filesystem for all secondary PHP instances
                proxyFileSystem(await requestHandler.getPrimaryPhp(), php, [
                    '/tmp',
                    requestHandler.documentRoot,
                    '/internal/shared',
                ]);
            }
            return php;
        },
        documentRoot,
        absoluteUrl: options.absoluteUrl,
        maxPhpInstances: options.numberOfPhpInstances,
        rewriteRules: wordPressRewriteRules,
        getFileNotFoundAction: getFileNotFoundActionForWordPress,
    });

    const php = await requestHandler.getPrimaryPhp();

    prepareDocumentRoot(php, options);

    output?.log(`directory: ${options.projectPath}`);
    output?.log(`mode: ${options.mode}`);
    output?.log(`php: ${options.phpVersion}`);


    let wpVersionOutput = options.wordPressVersion;


    output?.log(`wp: ${wpVersionOutput}`);



    await runWordPressMode(php, options);




    rotatePHPRuntime({
        php,
        cwd: requestHandler.documentRoot,
        recreateRuntime: async () => {
            output?.log('Recreating and rotating PHP runtime');
            const { php, runtimeId } = await getPHPInstance(options);
            prepareDocumentRoot(php, options);
            await runWordPressMode(php, options);
            return runtimeId;
        },
        maxRequests: 400,
    });

    return {
        php,
        options,
    };
}

async function getPHPInstance(
    options: WPNowOptions
): Promise<{ php: PHP; runtimeId: number }> {
    const id = await loadNodeRuntime(options.phpVersion ?? '8.2');
    const php = new PHP(id);

    await setPhpIniEntries(php, {
        memory_limit: '256M',
        disable_functions: '',
        allow_url_fopen: '1',
        'openssl.cafile': '/internal/shared/ca-bundle.crt',
    });

    return { php, runtimeId: id };
}

function prepareDocumentRoot(php: PHP, options: WPNowOptions) {
    if (!options.documentRoot) {
        throw new Error('Document root is required');
    }
    php.mkdir(options.documentRoot);
    php.chdir(options.documentRoot);
    php.writeFile(
        `${options.documentRoot}/index.php`,
        `<?php echo 'Hello wp-now!';`
    );
    php.writeFile(
        '/internal/shared/ca-bundle.crt',
        rootCertificates.join('\n')
    );
}

// async function prepareWordPress(php: PHP, options: WPNowOptions) {
//     switch (options.mode) {
//         case WPNowMode.WP_CONTENT:
//             await runWpContentMode(php, options);
//             break;
//         case WPNowMode.WORDPRESS_DEVELOP:
//             await runWordPressDevelopMode(php, options);
//             break;
//         case WPNowMode.WORDPRESS:
//             await runWordPressMode(php, options);
//             break;
//         case WPNowMode.PLUGIN:
//             await runPluginOrThemeMode(php, options);
//             break;
//         case WPNowMode.THEME:
//             await runPluginOrThemeMode(php, options);
//             break;
//         case WPNowMode.PLAYGROUND:
//             await runWpPlaygroundMode(php, options);
//             break;
//     }
// }

// async function runIndexMode(
//     php: PHP,
//     { documentRoot, projectPath }: WPNowOptions
// ) {
//     if (!documentRoot) {
//         throw new Error('Document root is required');
//     }
//     if (!projectPath) {
//         throw new Error('Project path is required');
//     }
//     await mountWithHandler(php, documentRoot, projectPath);
// }







/**
 * Initialize WordPress
 *
 * Initializes WordPress by copying sample config file to wp-config.php if it doesn't exist,
 * and sets up additional constants for PHP.
 *
 * It also returns information about whether the default database should be initialized.
 *
 * @param php
 * @param wordPressVersion
 * @param vfsDocumentRoot
 * @param siteUrl
 */
async function initWordPress(
    php: PHP,
    wordPressVersion: string,
    vfsDocumentRoot: string,
    siteUrl: string
) {
    let initializeDefaultDatabase = false;
    if (!php.fileExists(`${vfsDocumentRoot}/wp-config.php`)) {
        php.writeFile(
            `${vfsDocumentRoot}/wp-config.php`,
            php.readFileAsText(`${vfsDocumentRoot}/wp-config-sample.php`)
        );
        initializeDefaultDatabase = true;
    }



    return { initializeDefaultDatabase };
}


async function runWordPressMode(
    php: PHP,
    { documentRoot, wpContentPath, projectPath, absoluteUrl }: WPNowOptions
) {
    if (!documentRoot) {
        throw new Error('Document root is required');
    }
    if (!projectPath) {
        throw new Error('Project path is required');
    }
    if (!absoluteUrl) {
        throw new Error('Absolute URL is required');
    }
    await mountWithHandler(php, documentRoot, projectPath);

    const { initializeDefaultDatabase } = await initWordPress(
        php,
        'user-provided',
        documentRoot,
        absoluteUrl
    );

}