// tests/mock-cxml-api-orderRequest6.spec.ts
import { test, expect, request as playwrightRequest } from '@playwright/test';
import { createServer , Server} from 'http'; // モック用のapiサーバーを作る
import fs from 'fs';
import path from 'path';
const requestBodyXml = fs.readFileSync(path.join(__dirname,'../../server/mockdata/mock-cxml-api-orderRequest.xml'), 'utf-8' );
const mockResponseXml = fs.readFileSync(path.join(__dirname,'../../server/mockdata/mock-cxml-api-orderShipmentNotice.xml' ), 'utf-8');

import * as dotenv from 'dotenv';
dotenv.config();

const host = process.env.API_HOST;


let server: Server;
let port: number;

// モックサーバーを立てる
test.beforeEach(async ()=>{
  server = createServer((req, res)=>{
    if(req.method === 'POST' && req.url === '/orderRequest6'){
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
test('配送情報の確認。発送単位で送信される ※1つの注文が複数の発送に分かれる場合、注文単位ではなく発送単位となりますのでご注意ください。(orderRequest6)', async () => {
  const context = await playwrightRequest.newContext();
  const response = await context.post(`${host}:${port}/orderRequest6`, {
    headers: {
      'Content-Type': 'application/xml',
    },
    data: requestBodyXml,
  });


  expect(response.status()).toBe(200);

  const xmlText = await response.text();
  expect(xmlText).toContain('<?xml version="1.0" encoding="UTF-8"?>'); // 一部に含まれていること
  expect(xmlText).toMatch(/<cXML.*?>[\s\S]*<\/cXML>/);
  expect(xmlText).toMatch(/<Identity>Amazon<\/Identity>/);
  expect(xmlText).toMatch(/<UserAgent>Amazon LLC eProcurement Application<\/UserAgent>/);
  expect(xmlText).toMatch(/<Request.*?>[\s\S]*<\/Request>/);
  expect(xmlText).toMatch(/<Request.*?>[\s\S]*<\/Request>/);
  expect(xmlText).toMatch(/<OrderReference[^>]*\borderID="[^"]+"/);
  expect(xmlText).toMatch(/<DocumentReference[^>]*\bpayloadID="[^"]+"/);
  expect(xmlText).toMatch(/<Identity>[\s\S]*?<\/Identity>/);
  expect(xmlText).toBe(mockResponseXml); // 完全一致
});
