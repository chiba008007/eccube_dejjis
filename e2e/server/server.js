// server.js

const http = require('http');
const fs = require('fs');
const path = require('path');
const url = require('url');

const PORT = 3456;

const responseMap = {
  '/amazonApiSample': {
    contentType: 'application/xml',
    file: 'mock-cxml-api-response.xml'
  },
  '/punchOutSetupRequest2': {
    contentType: 'application/xml',
    file: 'mock-cxml-api-response-PunchOutSetupResponse.xml'
  },
  '/punchOutSetupRequest3': {
    contentType: 'application/xml',
    file: 'mock-cxml-api-response-PunchoutOrderMessage.xml'
  },
  '/orderRequest': {
    contentType: 'application/xml',
    file: 'mock-cxml-api-orderConfirmation.xml'
  },
  '/amazonJsonApiSample': {
    contentType: 'application/json',
    file: 'mock-json-api-response.json'
  },
};

const server = http.createServer((req, res) => {
  const parsedUrl = url.parse(req.url);
  const pathOnly = parsedUrl.pathname;

  const route = responseMap[pathOnly];

  if (req.method === 'POST' && route) {
    const { contentType, file } = route;
    const filePath = path.join(__dirname, 'mockdata', file);

    try {
      const responseData = fs.readFileSync(filePath, 'utf-8');
      res.writeHead(200, { 'Content-Type': contentType });
      res.end(responseData);
    } catch (err) {
      res.writeHead(500, { 'Content-Type': 'text/plain' });
      res.end('Internal Server Error');
    }

  } else {
    res.writeHead(404, { 'Content-Type': 'text/plain' });
    res.end('Not Found');
  }
});

server.listen(PORT, () => {
  console.log(`✅ Mock API Server running at http://localhost:${PORT}`);
});
