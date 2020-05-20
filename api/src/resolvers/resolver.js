import Restapi from '../restapi';
const restapi = new Restapi();
const manageError = response => {
  if (response.status === 'error') {
    return {
      status: resultado.response.status,
      errors: {
        value: resultado.response.value
      }
    };
  }
};

export default {
  Query: {
    checkBalance: async (parent, args, context) => {
      const resultado = await restapi.checkBalance(args);

      manageError(resultado.response);

      return resultado.response;
    }
  },
  Mutation: {
    registrarCliente: async (parent, args, context) => {
      const resultado = await restapi.registroCliente(args);

      manageError(resultado.response);

      return resultado.response;
    },
    rechargeWallet: async (parent, args, context) => {
      const resultado = await restapi.rechargeWallet(args);
      manageError(resultado.response);

      return resultado.response;
    },
    generateToken: async (parent, args, context) => {
      const resultado = await restapi.generateToken(args);

      manageError(resultado.response);

      return resultado.response;
    },
    confirmPayment: async (parent, args, context) => {
      const resultado = await restapi.confirmPayment(args);

      manageError(resultado.response);

      return resultado.response;
    }
  }
};
