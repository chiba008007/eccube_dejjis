// tests/mock-cxml-api-orderRequest.spec.ts
import { test, expect, request as playwrightRequest } from '@playwright/test';
import { createServer , Server} from 'http'; // モック用のapiサーバーを作る
import fs from 'fs';
import path from 'path';
const requestBodyXml = fs.readFileSync(path.join(__dirname,'../../server/mockdata/mock-cxml-api-orderRequest.xml'), 'utf-8' );
const mockResponseXml = fs.readFileSync(path.join(__dirname,'../../server/mockdata/mock-cxml-api-orderConfirmation_cancel.xml' ), 'utf-8');

import * as dotenv from 'dotenv';
dotenv.config();

const host = process.env.API_HOST;


let server: Server;
let port: number;

// モックサーバーを立てる
test.beforeEach(async ()=>{
  server = createServer((req, res)=>{
    if(req.method === 'POST' && req.url === '/orderRequestCancel'){
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
test('確定した注文金額情報の確認（全部キャンセル）。1注文に対して注文後24時間以内に1回送信される(orderRequestCancel)', async () => {
  const context = await playwrightRequest.newContext();
  const response = await context.post(`${host}:${port}/orderRequestCancel`, {
    headers: {
      'Content-Type': 'application/xml',
    },
    data: requestBodyXml,
  });


  expect(response.status()).toBe(200);

  const xmlText = await response.text();
  expect(xmlText).toContain('<?xml version="1.0" encoding="UTF-8"?>'); // 一部に含まれていること
  expect(xmlText).toMatch(/<cXML.*?>[\s\S]*<\/cXML>/);
  expect(xmlText).toMatch(/<ConfirmationHeader[^>]*\boperation="[^"]+"/);
  expect(xmlText).toMatch(/<Comments[^>]*\btype="OrderErrorCode"/);
  expect(xmlText).toMatch(/<ConfirmationStatus[^>]*\btype="reject"/);
  expect(xmlText).toMatch(/<Comments[^>]*\btype="LineItemErrorCode"/);

  expect(xmlText).toBe(mockResponseXml); // 完全一致
});
