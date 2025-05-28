
// tests/mock-api.spec.ts
import { test, expect, request as playwrightRequest } from '@playwright/test';
import { createServer , Server} from 'http'; // モック用のapiサーバーを作る
import fs from 'fs';
import path from 'path';
const requestBodyXml = fs.readFileSync(path.join(__dirname,'../../server/mockdata/mock-cxml-api-request-PunchOutSetupRequest.xml'), 'utf-8' );
const mockResponseXml = fs.readFileSync(path.join(__dirname,'../../server/mockdata/mock-cxml-api-response-PunchOutSetupResponse.xml' ), 'utf-8');

import * as dotenv from 'dotenv';
dotenv.config();

const host = process.env.API_HOST;


let server: Server;
let port: number;

// モックサーバーを立てる
test.beforeEach(async ()=>{
  server = createServer((req, res)=>{
    if(req.method === 'POST' && req.url === '/punchOutSetupRequest2'){
      res.writeHead(200, { 'Content-Type': 'application/xml' });
      res.end(mockResponseXml);
    }else{
      res.writeHead(404);
      res.end();
    }
  });

  await new Promise<void>((resolve)=> server.listen(0, resolve));

  const address = server.address();
  if(!address || typeof address === "string") throw new Error("サーバーのアドレス取得に失敗");
  port = address.port;
});

// サーバーを停止する
test.afterEach(async () => {
  await new Promise<void>((resolve, reject) => {
    server.close((err)=>{
      if(err) reject(err);
      else resolve();
    });
  });
});
test('モックAPIにPOSTして固定レスポンスを返す(PunchOutSetupResponse)', async () => {
  const context = await playwrightRequest.newContext();
  const response = await context.post(`${host}:${port}/punchOutSetupRequest2`, {
    headers: {
      'Content-Type': 'application/xml',
    },
    data: requestBodyXml,
  });


  expect(response.status()).toBe(200);

  const xmlText = await response.text();
  expect(xmlText).toContain('<?xml version="1.0" encoding="UTF-8"?>'); // 一部に含まれていること
  expect(xmlText).toContain('Success');
  // expect(xmlText).toMatch(/<cXML.*?>[sS]*</cXML>/);
  expect(xmlText).toBe(mockResponseXml); // 完全一致
});
