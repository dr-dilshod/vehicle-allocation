/**
 * Created by N0D1R on 03-Feb-20.
 */
module.exports = {

    data() {
        return {
            dialogTemplate: `
                    <div class="modal-content">
                    <div class="modal-header border-radius-0 bg-blue"><h5 class="modal-title">{{title}}</h5></div>
                     <div  class="modal-body">
                     <div class="text-center p-5"><div  v-html="text"></div></div>
                        <div class="text-center"><button class="btn btn-warning btn-fixed-width" @click="$emit('close')">OK</button></div>
                        </div>
                    </div>
            `,
            dialogConfirmTemplate: `
                <div class="modal-content">
                    <div class="modal-header border-radius-0 bg-blue"><h5 class="modal-title">{{title}}</h5></div>
                     <div  class="modal-body">
                     <div class="text-center p-5"><div  v-html="text"></div></div>
                        <div class="text-center">
                            <button class="btn btn-warning btn-fixed-width" @click="triggerOnConfirm">OK</button>
                            <button class="btn btn-default btn-fixed-width" @click="$emit('close')">{{this.__('common.cancel')}}</button>
                        </div>
                        </div>
                    </div>
            `,
            saveChangesTemplate: `
                <div class="modal-content">
                    <div class="modal-header border-radius-0 bg-blue"><h5 class="modal-title">{{title}}</h5></div>
                     <div  class="modal-body">
                     <div class="text-center p-5"><div  v-html="text"></div></div>
                        <div class="text-center">
                            <button class="btn btn-warning btn-fixed-width" @click="triggerOnConfirm">OK</button>
                            <button class="btn btn-default btn-fixed-width" @click="triggerDiscard">{{this.__('common.cancel')}}</button>
                        </div>
                        </div>
                    </div>
            `
        };
    },

    methods: {

        operationSuccessDialog() {
            this.$alert(this.__('alert.operation_successfully_done'), null, 'success', {confirmButtonText: this.__('alert.ok')});
        },
        confirmBack() {
            this.$modal.show({
                    template: this.dialogConfirmTemplate,
                    props: ['title', 'text', 'triggerOnConfirm']
                },
                {
                    title: this.__('alert.message'),
                    text: '編集中のデータを破棄して前の画面に戻りますか？',
                    triggerOnConfirm: () => {
                        window.location.href = this.backUrl;
                    }
                },
                {
                    height: 'auto',
                });
        },
        confirmDialog() {
            this.$modal.show({
                template: this.dialogConfirmTemplate,
                props: ['title', 'text', 'triggerOnConfirm']
            }, {title: this.__('common.confirm'), text: 'Are you sure?', triggerOnConfirm: () => {
                    return true;
                }}, {
                height: 'auto',
                width: 400
            });

            return false;
        },
        updateSuccessDialog() {
            this.$modal.show({
                template: this.dialogTemplate,
                props: ['title', 'text']
            }, {title: this.__('alert.done'), text: this.entityName() + this.__('alert.successfully_updated')}, {
                height: 'auto',
                width: 400
            });
        },

        deleteSuccessDialog() {
            this.$modal.show({
                template: this.dialogTemplate,
                props: ['title', 'text']
            }, {title: this.__('alert.done'), text: this.entityName() + this.__('alert.successfully_deleted')}, {
                height: 'auto',
                width: 400
            });
        },

        createSuccessDialog() {
            this.$modal.show({
                template: this.dialogTemplate,
                props: ['title', 'text']
            }, {title: this.__('alert.done'), text: this.entityName() + this.__('alert.successfully_created')}, {
                height: 'auto',
                width: 400
            });
        },
        showOperationSuccessDialog() {
            this.$modal.show({
                    template: this.dialogTemplate,
                    props: ['title', 'text']
                },
                {title: this.__('alert.done'), text: this.__('item.operation_is_successful')},
                {
                    height: 'auto',
                    width: 400
                });
        },

        errorDialog(error) {
            if (_.isNil(error)) {
                return;
            }
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
                template: this.dialogTemplate,
                props: ['title', 'text']
            }, {title: this.__('alert.message'), text: message}, {
                height: 'auto'
            });
        },

        loadErrorDialog() {
            this.$modal.show({
                template: this.dialogTemplate,
                props: ['title', 'text']
            }, {title: this.__('alert.message'), text: this.__('alert.error_on_loading_data_please_try_again')}, {
                height: 'auto'
            });
        },

        generalErrorDialog(){
            this.$modal.show({
                template: this.dialogTemplate,
                props: ['title', 'text']
            }, {title: this.__('alert.message'), text: 'You have errors in entered data. Please, fix them.'}, {
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
