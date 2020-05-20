import EasySoap from 'easysoap';
import 'dotenv/config';

const params = {
  host: process.env.URL,
  path: 'api/server',
  wsdl: 'api/server?wsdl'
};

var soapClient = EasySoap(params);

export default class Restapi {
  async registroCliente(data) {
    const callResponse = await soapClient.call({
      method: 'registroCliente',
      params: {
        ...data
      }
    });

    const json = soapClient.getXmlDataAsJson(
      callResponse.data.registroClienteResponse.return.content.value
    );
    json.statusCode =
      callResponse.data.registroClienteResponse.return.statusCode;

    return json;
  }

  async rechargeWallet(data) {
    const callResponse = await soapClient.call({
      method: 'rechargeWallet',
      params: {
        ...data
      }
    });

    const json = soapClient.getXmlDataAsJson(
      callResponse.data.rechargeWalletResponse.return.content.value
    );
    json.statusCode =
      callResponse.data.rechargeWalletResponse.return.statusCode;

    return json;
  }

  async checkBalance(data) {
    const callResponse = await soapClient.call({
      method: 'checkBalance',
      params: {
        ...data
      }
    });

    const json = soapClient.getXmlDataAsJson(
      callResponse.data.checkBalanceResponse.return.content.value
    );
    json.statusCode = callResponse.data.checkBalanceResponse.return.statusCode;

    return json;
  }

  async generateToken(data) {
    const callResponse = await soapClient.call({
      method: 'generateToken',
      params: {
        ...data
      }
    });

    const json = soapClient.getXmlDataAsJson(
      callResponse.data.generateTokenResponse.return.content.value
    );
    json.statusCode = callResponse.data.generateTokenResponse.return.statusCode;

    return json;
  }
  async confirmPayment(data) {
    const callResponse = await soapClient.call({
      method: 'confirmPayment',
      params: {
        ...data
      }
    });

    const json = soapClient.getXmlDataAsJson(
      callResponse.data.confirmPaymentResponse.return.content.value
    );
    json.statusCode =
      callResponse.data.confirmPaymentResponse.return.statusCode;

    return json;
  }
}
