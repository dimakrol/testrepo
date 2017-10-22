<template>
    <div class="container">
        <div v-if="!user.active_subscription">
            <h1>Checkout form</h1>
            <button class="btn btn-primary" @click="buySubscription">Bye Subscription</button>
        </div>
        <div v-else>
            <p>Your have yearly premium subscription.</p>
            <p>Next payment at: {{ nextPayment }}</p>
            <button class="btn btn-danger btn-sm" @click="cancelSubscription">Cancel Subscription</button>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['user'],
        methods: {
            buySubscription() {
                console.log(this.$data);

                this.stripe.open({
                    name: 'name',
                    description: 'description',
                    amount: 2500
                })
            },
            cancelSubscription() {
                axios.delete('subscription').then((response) => {
                    console.log(response);
                })
            },
        },
        data() {
            return {
                stripeEmail: '',
                stripeToken: ''
            }
        },
        mounted() {
            this.stripe = StripeCheckout.configure({
                key: WWD.stripe.stripeKey,
                image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                locale: 'auto',
                email: this.user.email,
                token: (token) => {

                    this.stripeEmail = token.email;
                    this.stripeToken = token.id;

                    axios.post('subscription', this.$data).then((response) => {
                        console.log(response);
                    })
                }
            });
        },
        computed: {
            nextPayment() {
                console.log(this.user.subscription_end_at);
                return moment(this.user.subscription_end_at).format('DD-MM-YYYY');
            }
        }
    }
</script>
