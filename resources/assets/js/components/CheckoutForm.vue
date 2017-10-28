<template>
    <div class="container">
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <ul v-if="!subscription" class="list-group col-md-6">
                    <li class="list-group-item">$ 9.99/year</li>
                    <li class="list-group-item">Unlimited videos.</li>
                    <li class="list-group-item">Donation to charity FOE</li>
                    <li class="list-group-item">30-Day money back guarantee</li>
                    <li class="list-group-item">
                        <button @click="subscribe" :disabled="subscribeBusy" type="button" class="btn btn-success btn-sm pull-right" >Subscribe</button>
                    </li>
                </ul>
                <div v-else-if="subscription && subscription.ends_at">
                    <p>Your have yearly premium subscription ends at: {{ subscription.ends_at }}</p>
                    <button @click="resumeSubscription" class="btn btn-warning btn-sm">Resume subscription</button>
                </div>
                <div v-else>
                    <p>Your have yearly premium subscription.</p>
                    <button @click="cancelSubscription" class="btn btn-danger btn-sm">Cancel Subscription</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
                user: {
                    type: Object,
                    required: true
                }
            },
        data() {
            return {
                subscribeBusy: false,
                stripeEmail: '',
                stripeToken: '',
                subscription: '',
            }
        },

        methods: {
            subscribe() {
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
            resumeSubscription() {

            }
        },

        mounted() {
            axios.get('/user').then((response) => {
                this.subscription = response.data;
            });
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
        },
        computed: {
            nextPayment() {
//                return moment(this.user.subscription_end_at).format('DD-MM-YYYY');
            }
        }
    }
</script>
