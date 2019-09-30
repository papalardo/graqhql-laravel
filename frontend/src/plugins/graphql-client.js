import ApolloClient from 'apollo-boost'
import VueApollo from 'vue-apollo'

export const apolloClient = new ApolloClient({
  // You should use an absolute URL here
  uri: 'http://localhost:8000/graphql'
})


export const apolloProvider = new VueApollo({
    defaultClient: apolloClient,
})