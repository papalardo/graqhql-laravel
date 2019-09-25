import Vue from 'vue'
import ApolloClient from 'apollo-boost'
import VueApollo from 'vue-apollo'

// import { InMemoryCache } from 'apollo-cache-inmemory';

export const apolloClient = new ApolloClient({
  // You should use an absolute URL here
  uri: 'http://localhost:8001/graphql',
  // cache: new InMemoryCache()
})

Vue.use(VueApollo)

export const apolloProvider = new VueApollo({
    defaultClient: apolloClient,
})