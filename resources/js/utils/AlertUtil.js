/**
 * Created by N0D1R on 03-Feb-20.
 */
module.exports = {

    data() {
        return {
            errorDialogTemplate: `
                    <div class="modal-content">
                    <div class="modal-header border-radius-0 bg-blue"><h5 class="modal-title">{{title}}</h5></div>
                     <div  class="modal-body">
                     <div  v-html="text"></div>
                        <div class="text-center"><button class="btn btn-warning btn-fixed-width" @click="$emit('close')">OK</button></div>
                        </div>
                    </div>
            `,
            doneDialogTemplate: `
                    <div class="modal-content">
                    <div class="modal-header bg-blue"><h5 class="modal-title">{{title}}</h5></div>
                     <div  class="modal-body">
                     <div class="text-center p-5">
                        <div  v-html="text"></div>
                     </div>
                        <div class="text-center"><button class="btn btn-warning btn-fixed-width" @click="$emit('close')">OK</button></div>
                        </div>
                    </div>
            `,
            max8: {
                maxLength: [(args) => {
                    return args['value'].length <= 8;
                }, this.__('alert.at_most_8_letters')]
            },
            max12: {
                maxLength: [(args) => {
                    return args['value'].length <= 12;
                }, this.__('alert.at_most_12_letters')]
            },
            max60: {
                maxLength: [(args) => {
                    return args['value'].length <= 60;
                }, this.__('alert.at_most_60_letters')]
            },
            max120: {
                maxLength: [(args) => {
                    return args['value'].length <= 120;
                }, this.__('alert.at_most_120_letters')]
            },
        };
    },

    methods: {

        operationSuccessDialog() {
            this.$alert(this.__('alert.operation_successfully_done'), null, 'success', {confirmButtonText: this.__('alert.ok')});
        },

        updateSuccessDialog() {
            this.$modal.show({
                template: this.doneDialogTemplate,
                props: ['title', 'text']
            }, {title: this.__('alert.done'), text: this.entityName() + this.__('alert.successfully_updated')}, {
                height: 'auto',
                width: 400
            });
        },

        deleteSuccessDialog() {
            this.$modal.show({
                template: this.doneDialogTemplate,
                props: ['title', 'text']
            }, {title: this.__('alert.done'), text: this.entityName() + this.__('alert.successfully_deleted')}, {
                height: 'auto',
                width: 400
            });
        },

        createSuccessDialog() {
            this.$modal.show({
                template: this.doneDialogTemplate,
                props: ['title', 'text']
            }, {title: this.__('alert.done'), text: this.entityName() + this.__('alert.successfully_created')}, {
                height: 'auto',
                width: 400
            });
        },

        errorDialog(error) {
            let status = error.response.status;
            if (status === 419 || status === 401) {
                location.reload();
                return;
            }

            let message = error.response.data.message;
            let errors = error.response.data.errors;

            message = '<h4>' + message + '</h4>';
            message += '<ol class="text-danger text-left h6">';
            $.each(errors, function (key, value) {
                message += '<li>' + value[0] + '</li>'; //showing only the first error.
            });
            message += '</ol>';
            this.$modal.show({
                template: this.errorDialogTemplate,
                props: ['title', 'text']
            }, {title: this.__('alert.message'), text: message}, {
                height: 'auto'
            });
        },

        loadErrorDialog() {
            this.$modal.show({
                template: this.errorDialogTemplate,
                props: ['title', 'text']
            }, {title: this.__('alert.message'), text: this.__('alert.error_on_loading_data_please_try_again')}, {
                height: 'auto'
            });
        },

        entityName() {
            switch (this.$options.name) {
                case 'VehicleTable' :
                    return this.__('validation.attributes.vehicle_list');
                case 'DepositRegistration':
                    return this.__('validation.attributes.deposit_registration');
                case 'Dispatch':
                    return this.__('validation.attributes.dispatch_board');
                case 'DriverTable':
                    return this.__('validation.attributes.driver_list');
                case 'Invoice':
                    return this.__('validation.attributes.invoice');
                case 'ItemList':
                    return this.__('validation.attributes.item_list');
                case 'ItemRegistration':
                    return this.__('validation.attributes.item_registration');
                case 'PaymentBkReport':
                    return this.__('validation.attributes.payment_registration');
                case 'PaymentRegistration':
                    return this.__('validation.attributes.payment_registration');
                case 'ShipperTable':
                    return this.__('validation.attributes.shipper');
                case 'Top':
                    return 'Top';
                case 'UnitPriceTable':
                    return this.__('validation.attributes.unit_price');
                default:
                    return 'Item';
            }
        }
    }
};
