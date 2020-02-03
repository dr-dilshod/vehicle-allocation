/**
 * Created by N0D1R on 03-Feb-20.
 */
module.exports = {

    methods : {

        operationSuccessDialog() {
            this.$alert('Operation successfully done!');
        },

        updateSuccessDialog(){
            this.$alert(this.entityName()+' successfully updated!');
        },

        deleteSuccessDialog(){
            this.$alert(this.entityName()+' successfully deleted!');
        },

        createSuccessDialog(){
            this.$alert(this.entityName()+' successfully created!');
        },

        errorDialog(response){
            let message = response.message + ': ';
            let errors = response.errors;
            $.each( errors, function( key, value ) {
                message += value[0]; //showing only the first error.
            });
            this.$alert(message);
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
