/**
 * Created by N0D1R on 03-Feb-20.
 */
module.exports = {

    data(){
        return {
            max8 : {maxLength:[(args) => {return args['value'].length <= 8;}, this.__('alert.at_most_8_letters')]},
            max12 : {maxLength:[(args) => {return args['value'].length <= 12;}, this.__('alert.at_most_12_letters')]},
            max60 : {maxLength:[(args) => {return args['value'].length <= 60;}, this.__('alert.at_most_60_letters')]},
            max120 : {maxLength:[(args) => {return args['value'].length <= 120;}, this.__('alert.at_most_120_letters')]},
        };
    },

    methods : {

        operationSuccessDialog() {
            this.$alert(this.__('alert.operation_successfully_done'), null, 'success',{confirmButtonText: this.__( 'alert.ok')});
        },

        updateSuccessDialog(){
            this.$alert(this.entityName()+ this.__('alert.successfully_updated'), null, 'success',{confirmButtonText: this.__( 'alert.ok')});
        },

        deleteSuccessDialog(){
            this.$alert(this.entityName()+ this.__('alert.successfully_deleted'), null, 'success',{confirmButtonText: this.__( 'alert.ok')});
        },

        createSuccessDialog(){
            this.$alert(this.entityName()+ this.__('alert.successfully_created'), null, 'success',{confirmButtonText: this.__( 'alert.ok')});
        },

        errorDialog(error){
            let status = error.response.status;
            let message = error.response.data.message;
            let errors = error.response.data.errors;

            message = '<h4>'+message+'</h4>';
            message += '<ol class="text-danger text-left h6">';
            $.each( errors, function( key, value ) {
                message += '<li>'+value[0]+'</li>'; //showing only the first error.
            });
            message += '</ol>';
            this.$fire({
                icon : 'error',
                html : message,
                type: "error",
            });
        },

        loadErrorDialog(){
            this.$alert(this.__('alert.error_on_loading_data_please_try_again'), null, 'warning',{confirmButtonText: this.__( 'alert.ok')});
        },

        entityName(){
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
                    'Item'
            }
        }
    }
};
