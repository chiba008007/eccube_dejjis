// e2e/server/server.js

const http = require('http');
const fs = require('fs');
const path = require('path');

const PORT = 3456;

const requestXml = fs.readFileSync(path.join(__dirname, 'mockdata/mock-cxml-api-request.xml'), 'utf-8');
const responseXml = fs.readFileSync(path.join(__dirname, 'mockdata/mock-cxml-api-response.xml'), 'utf-8');

const server = http.createServer((req, res) => {
  if (req.method === 'POST' && req.url === '/amazonApiSample') {
    res.writeHead(200, { 'Content-Type': 'application/xml' });
    res.end(responseXml);
  } else {
    res.writeHead(404, { 'Content-Type': 'text/plain' });
    res.end('Not Found');
  }
});

server.listen(PORT, () => {
  console.log(`✅ Mock API Server running at http://localhost:${PORT}`);
});
