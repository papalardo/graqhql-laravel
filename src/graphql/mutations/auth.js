import gql from 'graphql-tag'

export const LOGIN_MUTATION = gql`mutation ($username: String!, $password: String!) {
    login(input: {
        username: $username
        password: $password
    }) {
        access_token
        token_type
        expires_in
    }
}`