<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuesax Admin - VueJS Dashboard Admin Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center" id="page-login">
        <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row no-gutter justify-center items-center">
                        <div class="vx-col hidden lg:block lg:w-1/2">
                            <img src="@/assets/images/pages/login.png" alt="login" class="mx-auto">
                        </div>
                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 d-theme-dark-bg">
                            <div class="p-8">
                                <div class="vx-card__title mb-8">
                                    <h4 class="mb-4">Login</h4>
                                    <p>Bem-vindo, por favor, faça login na sua conta.</p>
                                </div>
                                <vs-input
                                    v-validate="'required|email|min:3'"
                                    data-vv-validate-on="blur"
                                    name="email"
                                    icon="icon icon-user"
                                    icon-pack="feather"
                                    label-placeholder="Email"
                                    v-model="email"
                                    class="w-full no-icon-border"/>
                                <span class="text-danger text-sm">{{ errors.first('email') }}</span>

                                <vs-input
                                    data-vv-validate-on="blur"
                                    v-validate="'required|min:6|max:10'"
                                    type="password"
                                    name="password"
                                    icon="icon icon-lock"
                                    icon-pack="feather"
                                    label-placeholder="Senha"
                                    v-model="password"
                                    class="w-full mt-6 no-icon-border" />
                                <span class="text-danger text-sm">{{ errors.first('password') }}</span>

                                <div class="flex flex-wrap justify-between my-5">
                                    <vs-checkbox v-model="checkbox_remember_me" class="mb-3">Lembrar de mim</vs-checkbox>
                                    <router-link to="/pages/forgot-password">Esqueceu a senha?</router-link>
                                </div>
                                <vs-button  type="border" @click="registerUser">Registrar</vs-button>
                                <vs-button class="float-right" :disabled="!validateForm" @click="login">Login</vs-button>
                            </div>
                        </div>
                    </div>
                </div>
            </vx-card>
        </div>
    </div>
</template>

<script>
import gql from 'graphql-tag'
export default {
    data() {
        return {
            email: 'papalardo944@hotmail.com',
            password: '@admin123',
            checkbox_remember_me: false
        }
    },
    computed: {
        validateForm() {
            return !this.errors.any() && this.email != '' && this.password != '';
        },
    },
    methods: {
        async login() {
            const payload = {
                username: this.email,
                password: this.password
            }
            try {
                await this.$store.dispatch('auth/loginAttempt', payload);
                this.$router.push({ path: this.$router.currentRoute.query.to || '/' });
                this.notifyAlreadyLogedIn()
            } catch (err) {
                console.log(err.message);
                this.$vs.notify({
                    time: 2500,
                    title: 'Erro..',
                    text: 'Credenciais inválidas',
                    iconPack: 'feather',
                    icon: 'icon-alert-circle',
                    color: 'danger'
                })
            }
        },
        notifyAlreadyLogedIn() {
            this.$vs.notify({
                title: 'Login Attempt',
                text: 'You are already logged in!',
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'warning'
            });
        },
        registerUser() {
            if(this.$store.state.auth.isUserLoggedIn()) {
                this.notifyAlreadyLogedIn();
                return false;
            }
            this.$router.push('/pages/register');
        }
    }
}
</script>

<style lang="scss">
#page-login {
    .social-login {
        .bg-facebook {
          background-color: #1551b1;
        }
        .bg-twitter {
          background-color: #00aaff;
        }
        .bg-google {
          background-color: #4285F4;
        }
        .bg-github {
          background-color: #333;
        }
    }
}
</style>
