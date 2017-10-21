<template>
    <div class="container">
        <h1>Checkout form</h1>
        <button id="customButton" @click="buySubscription">Purchase</button>
    </div>

</template>

<script>
    export default {
        methods: {
            buySubscription() {
                console.log(this.$data);

                this.stripe.open({
                    name: 'name',
                    description: 'description',
                    zipCode: true,
                    amount: 2500
                })
            }
        },
        data() {
            return {
                stripe: {},
                stripeEmail: '',
                stripeToken: ''
            }
        },
        mounted() {

            this.stripe = StripeCheckout.configure({
                key: WWD.stripe.stripeKey,
                image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                locale: 'auto',
                email: WWD.user.email,
                token: (token) => {

                    vm.stripeEmail = token.email;
                    vm.stripeToken = token.id;

                    axios.post('subscription', this.$data).then((response) => {
                        console.log(response);
                    })
                }
            });
        }
    }
</script>
