<?php if ( $metrics_table[ 'layout' ] == 'horizontal' ) {
    ?>
    <div id="<?php echo esc_attr( $m_table[ 'id' ] ); ?>" class="zcpri_metrics_table zcpri_horizontal_table">
        <?php
        if ( $m_table[ 'table_title' ][ 'enable' ] == 'yes' ) {
            ?>
            <h2 class="zcpri_metrics_table_title"><?php echo wp_kses_post( $m_table[ 'table_title' ][ 'title' ] ); ?></h2>
            <?php
        }
        ?>
        <table>
            <?php
            if ( $m_table[ 'quatity_row' ][ 'enable' ] == 'yes' ) {
                ?>
                <tr>
                    <?php if ( $metrics_table[ 'show_headers' ] == 'yes' ) {
                        ?><th><?php echo wp_kses_post( $m_table[ 'quatity_row' ][ 'label' ] ); ?></th><?php
                    }
                    if ( isset( $product_prop[ 'prices_table' ] ) ) {
                        foreach ( $product_prop[ 'prices_table' ] as $price_qty ) {
                            if ( count( $price_qty[ 'qty' ] ) > 1 ) {
                                $qty_text = str_replace( '[0]', $price_qty[ 'qty' ][ 0 ], esc_html__( '[0] - [1]', 'zcpri-woopricely' ) );
                                $qty_text = str_replace( '[1]', $price_qty[ 'qty' ][ 1 ], $qty_text );
                            } else {
                                $qty_text = str_replace( '[0]', $price_qty[ 'qty' ][ 0 ], esc_html__( '[0] +', 'zcpri-woopricely' ) );
                            }
                            ?><th><?php echo wp_kses_post( $qty_text ); ?></th><?php
                            }
                        }
                        ?>                                
                </tr>
                <?php
            }

            if ( $m_table[ 'price_row' ][ 'enable' ] == 'yes' ) {
                ?>
                <tr>
                    <?php if ( $metrics_table[ 'show_headers' ] == 'yes' ) {
                        ?><th><?php echo wp_kses_post( $m_table[ 'price_row' ][ 'label' ] ); ?></th><?php
                    }
                    if ( isset( $product_prop[ 'prices_table' ] ) ) {
                        foreach ( $product_prop[ 'prices_table' ] as $price ) {
                            ?><td><?php
                                    if ( count( $price[ 'price' ] ) > 1 ) {
                                        $price_value = str_replace( '[0]', wc_price( $price[ 'price' ][ 0 ] ), esc_html__( '[0] - [1]', 'zcpri-woopricely' ) );
                                        $price_value = str_replace( '[1]', wc_price( $price[ 'price' ][ 1 ] ), $price_value );
                                        echo wp_kses_post( $price_value );
                                    } else {
                                        echo wp_kses_post( wc_price( $price[ 'price' ][ 0 ] ) );
                                    }
                                    ?></td><?php
                        }
                    }
                    ?>
                </tr>
                <?php
            }
            if ( $m_table[ 'price_per_row' ][ 'enable' ] == 'yes' ) {
                ?>
                <tr>
                    <?php if ( $metrics_table[ 'show_headers' ] == 'yes' ) {
                        ?><th><?php echo wp_kses_post( $m_table[ 'price_per_row' ][ 'label' ] ); ?></th><?php
                    }
                    if ( isset( $product_prop[ 'prices_table' ] ) ) {
                        foreach ( $product_prop[ 'prices_table' ] as $price ) {
                            $price_per_text = esc_html__( '[0]%', 'zcpri-woopricely' );
                            if ( count( $price[ 'price' ] ) > 1 ) {
                                $price_per_text = esc_html__( '[0]% - [1]%', 'zcpri-woopricely' );
                                $price_per_text = str_replace( '[0]', round( ($price[ 'price' ][ 0 ] / $product_prop[ 'price' ][ 0 ]) * 100, 2 ), $price_per_text );
                                $price_per_text = str_replace( '[1]', round( ($price[ 'price' ][ 1 ] / $product_prop[ 'price' ][ 1 ]) * 100, 2 ), $price_per_text );
                            } else {
                                $price_per_text = str_replace( '[0]', round( ($price[ 'price' ][ 0 ] / $product_prop[ 'price' ][ 0 ]) * 100, 2 ), $price_per_text );
                            }
                            ?><td><?php echo wp_kses_post( $price_per_text ); ?></td><?php
                            }
                        }
                        ?>
                </tr>
                <?php
            }
            if ( $m_table[ 'discount_row' ][ 'enable' ] == 'yes' ) {
                ?>
                <tr>
                    <?php if ( $metrics_table[ 'show_headers' ] == 'yes' ) {
                        ?><th><?php echo wp_kses_post( $m_table[ 'discount_row' ][ 'label' ] ); ?></th><?php
                    }
                    if ( isset( $product_prop[ 'prices_table' ] ) ) {
                        foreach ( $product_prop[ 'prices_table' ] as $discount ) {
                            $disc_text = esc_html__( '[0]', 'zcpri-woopricely' );
                            if ( count( $product_prop[ 'price' ] ) > 1 ) {
                                $disc_text = esc_html__( '[0] - [1]', 'zcpri-woopricely' );
                                $disc_text = str_replace( '[0]', wc_price( round( $product_prop[ 'price' ][ 0 ] - $discount[ 'price' ][ 0 ], wc_get_price_decimals() ) ), $disc_text );
                                $disc_text = str_replace( '[1]', wc_price( round( $product_prop[ 'price' ][ 1 ] - $discount[ 'price' ][ 1 ], wc_get_price_decimals() ) ), $disc_text );
                            } else {
                                $disc_text = str_replace( '[0]', wc_price( round( $product_prop[ 'price' ][ 0 ] - $discount[ 'price' ][ 0 ], wc_get_price_decimals() ) ), $disc_text );
                            }
                            ?><td><?php echo wp_kses_post( $disc_text ); ?></td><?php
                            }
                        }
                        ?>
                </tr>
                <?php
            }
            if ( $m_table[ 'discount_per_row' ][ 'enable' ] == 'yes' ) {
                ?>
                <tr>
                    <?php if ( $metrics_table[ 'show_headers' ] == 'yes' ) {
                        ?><th><?php echo wp_kses_post( $m_table[ 'discount_per_row' ][ 'label' ] ); ?></th><?php
                    }
                    if ( isset( $product_prop[ 'prices_table' ] ) ) {
                        foreach ( $product_prop[ 'prices_table' ] as $discount ) {



                            $disc_per_text = esc_html__( '[0]%', 'zcpri-woopricely' );
                            if ( count( $product_prop[ 'price' ] ) > 1 ) {
                                $disc_per_text = esc_html__( '[0]% - [1]%', 'zcpri-woopricely' );
                                $disc_per_text = str_replace( '[0]', round( (($product_prop[ 'price' ][ 0 ] - $discount[ 'price' ][ 0 ]) / $product_prop[ 'price' ][ 0 ] ) * 100, 2 ), $disc_per_text );
                                $disc_per_text = str_replace( '[1]', round( (($product_prop[ 'price' ][ 1 ] - $discount[ 'price' ][ 1 ]) / $product_prop[ 'price' ][ 1 ] ) * 100, 2 ), $disc_per_text );
                            } else {
                                $disc_per_text = str_replace( '[0]', round( (($product_prop[ 'price' ][ 0 ] - $discount[ 'price' ][ 0 ]) / $product_prop[ 'price' ][ 0 ] ) * 100, 2 ), $disc_per_text );
                            }
                            ?><td><?php echo esc_html( $disc_per_text ); ?></td><?php
                            }
                        }
                        ?>
                </tr>
                <?php
            }
            ?>                        
        </table> 
    </div>
    <?php
} else {
    ?>
    <div id="<?php echo esc_attr( $m_table[ 'id' ] ); ?>" class="zcpri_metrics_table zcpri_vertical_table">
        <?php
        if ( $m_table[ 'table_title' ][ 'enable' ] == 'yes' ) {
            ?>
            <h2 class="zcpri_metrics_table_title"><?php echo wp_kses_post( $m_table[ 'table_title' ][ 'title' ] ); ?></h2>
            <?php
        }
        ?>
        <table>
            <tr>
                <?php
                if ( $metrics_table[ 'show_headers' ] == 'yes' ) {
                    if ( $m_table[ 'quatity_row' ][ 'enable' ] == 'yes' ) {
                        ?><th><?php echo wp_kses_post( $m_table[ 'quatity_row' ][ 'label' ] ) ?></th><?php
                    }
                    if ( $m_table[ 'price_row' ][ 'enable' ] == 'yes' ) {
                        ?><th><?php echo wp_kses_post( $m_table[ 'price_row' ][ 'label' ] ) ?></th><?php
                        }
                        if ( $m_table[ 'price_per_row' ][ 'enable' ] == 'yes' ) {
                            ?><th><?php echo wp_kses_post( $m_table[ 'price_per_row' ][ 'label' ] ) ?></th><?php
                        }
                        if ( $m_table[ 'discount_row' ][ 'enable' ] == 'yes' ) {
                            ?><th><?php echo wp_kses_post( $m_table[ 'discount_row' ][ 'label' ] ) ?></th><?php
                        }
                        if ( $m_table[ 'discount_per_row' ][ 'enable' ] == 'yes' ) {
                            ?><th><?php echo wp_kses_post( $m_table[ 'discount_per_row' ][ 'label' ] ) ?></th><?php
                        }
                    }
                    ?>
            </tr>
            <?php
            if ( isset( $product_prop[ 'prices_table' ] ) ) {
                foreach ( $product_prop[ 'prices_table' ] as $price ) {
                    ?>
                    <tr>
                        <?php
                        if ( count( $price[ 'qty' ] ) > 1 ) {
                            $qty_text = str_replace( '[0]', $price[ 'qty' ][ 0 ], esc_html__( '[0] - [1]', 'zcpri-woopricely' ) );
                            $qty_text = str_replace( '[1]', $price[ 'qty' ][ 1 ], $qty_text );
                        } else {
                            $qty_text = str_replace( '[0]', $price[ 'qty' ][ 0 ], esc_html__( '[0] +', 'zcpri-woopricely' ) );
                        }
                        if ( $m_table[ 'quatity_row' ][ 'enable' ] == 'yes' ) {
                            ?><th><?php echo wp_kses_post( $qty_text ); ?></th><?php
                        }
                        ?>
                        <?php
                        if ( $m_table[ 'price_row' ][ 'enable' ] == 'yes' ) {
                            ?><td><?php
                                    if ( count( $price[ 'price' ] ) > 1 ) {
                                        $price_value = str_replace( '[0]', wc_price( $price[ 'price' ][ 0 ] ), esc_html__( '[0] - [1]', 'zcpri-woopricely' ) );
                                        $price_value = str_replace( '[1]', wc_price( $price[ 'price' ][ 1 ] ), $price_value );
                                        echo wp_kses_post( $price_value );
                                    } else {
                                        echo wp_kses_post( wc_price( $price[ 'price' ][ 0 ] ) );
                                    }
                                    ?></td><?php
                        }
                        if ( $m_table[ 'price_per_row' ][ 'enable' ] == 'yes' ) {
                            $price_per_text = esc_html__( '[0]%', 'zcpri-woopricely' );
                            if ( count( $price[ 'price' ] ) > 1 ) {
                                $price_per_text = esc_html__( '[0]% - [1]%', 'zcpri-woopricely' );
                                $price_per_text = str_replace( '[0]', round( ($price[ 'price' ][ 0 ] / $product_prop[ 'price' ][ 0 ]) * 100, 2 ), $price_per_text );
                                $price_per_text = str_replace( '[1]', round( ($price[ 'price' ][ 1 ] / $product_prop[ 'price' ][ 1 ]) * 100, 2 ), $price_per_text );
                            } else {
                                $price_per_text = str_replace( '[0]', round( ($price[ 'price' ][ 0 ] / $product_prop[ 'price' ][ 0 ]) * 100, 2 ), $price_per_text );
                            }
                            ?><td><?php echo esc_html( $price_per_text ); ?></td><?php
                            }

                            if ( $m_table[ 'discount_row' ][ 'enable' ] == 'yes' ) {
                                $disc_text = esc_html__( '[0]', 'zcpri-woopricely' );
                                if ( count( $product_prop[ 'price' ] ) > 1 ) {
                                    $disc_text = esc_html__( '[0] - [1]', 'zcpri-woopricely' );
                                    $disc_text = str_replace( '[0]', wc_price( round( $product_prop[ 'price' ][ 0 ] - $price[ 'price' ][ 0 ], wc_get_price_decimals() ) ), $disc_text );
                                    $disc_text = str_replace( '[1]', wc_price( round( $product_prop[ 'price' ][ 1 ] - $price[ 'price' ][ 1 ], wc_get_price_decimals() ) ), $disc_text );
                                } else {
                                    $disc_text = str_replace( '[0]', wc_price( round( $product_prop[ 'price' ][ 0 ] - $price[ 'price' ][ 0 ], wc_get_price_decimals() ) ), $disc_text );
                                }
                                ?><td><?php echo wp_kses_post( $disc_text ); ?></td><?php
                        }
                        if ( $m_table[ 'discount_per_row' ][ 'enable' ] == 'yes' ) {

                            $disc_per_text = esc_html__( '[0]%', 'zcpri-woopricely' );
                            if ( count( $product_prop[ 'price' ] ) > 1 ) {
                                $disc_per_text = esc_html__( '[0]% - [1]%', 'zcpri-woopricely' );
                                $disc_per_text = str_replace( '[0]', round( (($product_prop[ 'price' ][ 0 ] - $price[ 'price' ][ 0 ]) / $product_prop[ 'price' ][ 0 ] ) * 100, 2 ), $disc_per_text );
                                $disc_per_text = str_replace( '[1]', round( (($product_prop[ 'price' ][ 1 ] - $price[ 'price' ][ 1 ]) / $product_prop[ 'price' ][ 1 ] ) * 100, 2 ), $disc_per_text );
                            } else {
                                $disc_per_text = str_replace( '[0]', round( (($product_prop[ 'price' ][ 0 ] - $price[ 'price' ][ 0 ]) / $product_prop[ 'price' ][ 0 ] ) * 100, 2 ), $disc_per_text );
                            }
                            ?><td><?php echo esc_html( $disc_per_text ); ?></td><?php
                        }
                        ?>
                    </tr> <?php
                }
            }
            ?>
        </table> 
    </div>
    <?php
}