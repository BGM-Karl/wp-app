// import express from 'express';
// ​
// const app = express();
// const port = 3000;
// app.get('/', (req, res) => {
//   res.send('The server is working!');
// });
// app.listen(port, () => {
//   if (port === 3000) {
//     console.log('true')
//   }
//   console.log(`server is listening on ${port} !!!`);
// });

import { startServer } from "./start-server";


// 目前這個專案的路徑
const currentPath = process.cwd();
console.log('currentPath', currentPath);
const projectPath = `${currentPath}/www`;


startServer({
  projectPath,
  documentRoot: projectPath,
  mode: 'wordpress',
  absoluteUrl: 'https://localhost:8080',
  port: 8080,
  phpVersion: '8.3',
})