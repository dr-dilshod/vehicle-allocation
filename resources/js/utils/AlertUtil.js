/**
 * Created by N0D1R on 03-Feb-20.
 */
module.exports = {

    methods : {

        operationSuccessDialog() {
            this.$alert('Operation successfully done!', null, 'success');
        },

        updateSuccessDialog(){
            this.$alert(this.entityName()+' successfully updated!', null, 'success');
        },

        deleteSuccessDialog(){
            this.$alert(this.entityName()+' successfully deleted!', null, 'success');
        },

        createSuccessDialog(){
            this.$alert(this.entityName()+' successfully created!', null, 'success');
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
            });
        },

        entityName(){
            switch (this.$options.name) {
                case 'VehicleTable' :
                    return "Vehicle";
                case 'DepositRegistration':
                    return 'Deposit';
                case 'Dispatch':
                    return 'Dispatch';
                case 'DriverTable':
                    return 'Driver';
                case 'Invoice':
                    return 'Invoice';
                case 'ItemList':
                    return 'Item';
                case 'ItemRegistration':
                    return 'Item';
                case 'PaymentBkReport':
                    return 'Payment';
                case 'PaymentRegistration':
                    return 'Payment';
                case 'ShipperTable':
                    return 'Shipper';
                case 'Top':
                    return 'Top';
                case 'UnitPriceTable':
                    return 'Unit price';
                case 'VehicleTable':
                    return 'Vehicle';
                default:
                    'Item'
            }
        }
    }
};
