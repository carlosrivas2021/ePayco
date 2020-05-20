import express from 'express';
import graphqlHTTP from 'express-graphql';
import { createServer } from 'http';
import { fileLoader, mergeTypes, mergeResolvers } from 'merge-graphql-schemas';
import { makeExecutableSchema } from 'graphql-tools';
import path from 'path';
import cors from 'cors';
import 'dotenv/config';
import { apolloUploadExpress } from 'apollo-upload-server';
import { SubscriptionServer } from 'subscriptions-transport-ws';
import { execute, subscribe } from 'graphql';

import Restapi from './restapi';

const restapi = new Restapi();

// restapi.dos();
const app = express();

// app.use(express.bodyParser());

const typeDefs = mergeTypes(fileLoader(path.join(__dirname, './types')));
const resolvers = mergeResolvers(
  fileLoader(path.join(__dirname, './resolvers'))
);

const schema = makeExecutableSchema({
  typeDefs,
  resolvers
});
const PORT = process.env.PORT;
const WS_GQL_PATH = '/subscriptions';

app.use(cors());

app.use(
  '/graphql',
  graphqlHTTP(req => ({
    graphiql: true,
    schema,
    context: {}
  }))
);

app.use(express.urlencoded({ extended: true }));

app.get('/', async (req, res) => {
  res.json({
    message: 'Apunte al endpoint correcto'
  });
});

app.post('/api/registrocliente', async (req, res) => {
  const resultado = await restapi.registroCliente(req.body);
  res.status(resultado.statusCode.value).json(resultado.response);
});
app.post('/api/rechargewallet', async (req, res) => {
  const resultado = await restapi.rechargeWallet(req.body);
  res.status(resultado.statusCode.value).json(resultado.response);
});
app.post('/api/checkbalance', async (req, res) => {
  const resultado = await restapi.checkBalance(req.body);
  res.status(resultado.statusCode.value).json(resultado.response);
});
app.post('/api/generatetoken', async (req, res) => {
  const resultado = await restapi.generateToken(req.body);
  res.status(resultado.statusCode.value).json(resultado.response);
});
app.post('/api/confirmpayment', async (req, res) => {
  const resultado = await restapi.confirmPayment(req.body);
  res.status(resultado.statusCode.value).json(resultado.response);
});

const server = createServer(app);

server.listen(PORT, () => {
  console.log(`Server on port ${PORT}`);
  console.log(
    `API Server over web socket with subscriptions is now running on ws://localhost:${PORT}${WS_GQL_PATH}`
  );
});

new SubscriptionServer(
  { schema, execute, subscribe },
  { server, path: WS_GQL_PATH }
);
