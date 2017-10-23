<template>
    <div class="container">
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <ul class="list-group col-md-6">
                    <li class="list-group-item">$ 9.99/year</li>
                    <li class="list-group-item">Unlimited videos.</li>
                    <li class="list-group-item">Donation to charity FOE</li>
                    <li class="list-group-item">30-Day money back guarantee</li>
                    <li class="list-group-item">
                        <button @click="subscribe" :disabled="subscribeBusy" type="button" class="btn btn-success btn-sm pull-right" >Subscribe</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

        <!--<div v-else>-->
            <!--<p>Your have yearly premium subscription.</p>-->
            <!--<p>Next payment at: {{ nextPayment }}</p>-->
            <!--<button class="btn btn-danger btn-sm" @click="cancelSubscription">Cancel Subscription</button>-->
        <!--</div>-->

</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                subscribeBusy: false,
                stripeEmail: '',
                stripeToken: ''
            }
        },

        methods: {
            subscribe() {
                console.log(this.$data);
                this.subscribeBusy = true;

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

        mounted() {
            this.stripe = StripeCheckout.configure({
                key: WWD.stripe.stripeKey,
                image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                locale: 'auto',
                email: this.user.email,
                closed: () => {
                    this.subscribeBusy = false;
                },
                token: (token) => {

                    this.stripeEmail = token.email;
                    this.stripeToken = token.id;

                    axios.post('subscription', this.$data).then((response) => {
                        this.subscribeBusy = false;
                        console.log(response);
                    })
                }
            });

            this.stripe.close(() => {
                console.log('dddd')
            })
        },
        computed: {
            nextPayment() {
                console.log(this.user.subscription_end_at);
                return moment(this.user.subscription_end_at).format('DD-MM-YYYY');
            }
        }
    }
</script>
