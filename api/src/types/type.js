export default `
    
    type Error{
        value: [String]!
    }

    type Response {
        status: String
        value: String
        errors: Error
    }

    type Query {
        checkBalance(dni: String!, phone: String!): Response!
    }

    type Mutation{
        registrarCliente(name: String!, dni: String!, email: String!, phone: String!): Response!
        rechargeWallet(dni: String!, phone: String!, amount: Float!): Response!
        generateToken(dni: String!, phone: String!, amount: Float!): Response!
        confirmPayment(id: String!, token: String!): Response!
    }
`;