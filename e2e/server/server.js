// e2e/server/server.js

const http = require('http');
const fs = require('fs');
const path = require('path');

const PORT = 3456;

// const requestXml = fs.readFileSync(path.join(__dirname, 'mockdata/mock-cxml-api-request.xml'), 'utf-8');
// const responseXml = fs.readFileSync(path.join(__dirname, 'mockdata/mock-cxml-api-response.xml'), 'utf-8');


const responseMap = {
  '/amazonApiSample': {
    contentType: 'application/xml',
    file: 'mock-cxml-api-response.xml'
  },
  '/amazonApiSample/PunchoutOrderMessage': {
    contentType: 'application/xml',
    file: 'mock-cxml-api-response-PunchoutOrderMessage.xml'
  },
  '/punchOutSetupRequestPunchoutOrderMessage': {
    contentType: 'application/xml',
    file: 'mock-cxml-api-response-PunchoutOrderMessage.xml'
  },
  '/amazonJsonApiSample': {
    contentType: 'application/json',
    file: 'mock-json-api-response.json'
  },

};


const server = http.createServer((req, res) => {
  if (req.method === 'POST' && responseMap[req.url] ) {
    const { contentType, file } = responseMap[req.url];
    const filePath = path.join(__dirname, 'mockdata', file);

    try{
      const responseData = fs.readFileSync(filePath, 'utf-8');
      res.writeHead(200, { 'Content-Type': contentType });
      res.end(responseData);
    }catch(err){
      res.writeHead(500, { 'Content-Type': 'text/plain' });
      res.end( 'Internal Server Error' );
    }

  } else {
    res.writeHead(404, { 'Content-Type': 'text/plain' });
    res.end('Not Found');
  }
});

server.listen(PORT, () => {
  console.log(`✅ Mock API Server running at http://localhost:${PORT}`);
});
