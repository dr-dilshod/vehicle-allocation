/**
 * Created by N0D1R on 09-Feb-20.
 */
import { L10n, setCulture } from '@syncfusion/ej2-base';

setCulture('ja-JA');
// setCulture('en-EN');
// setCurrencyCode('EUR');
/**
 * Visit for more properties
 * https://help.syncfusion.com/js/grid/globalizationandlocalization
 */

L10n.load({
    'ja-JA': {
        'grid': {
            'SaveButton' : window.__('common.update'),
            'CancelButton' : window.__('common.cancel'),
            'OKButton' : window.__('common.ok'),
            'Save' : window.__('common.save'),
            'Add' : window.__('common.add'),
            'Edit' : window.__('common.edit'),
            'Delete' : window.__('common.delete'),
            'Update' : window.__('common.update'),
            'Exit' : window.__('common.exit'),
            'Cancel' : window.__('common.cancel'),
            'Done' : window.__('common.done'),
            'EmptyRecord': window.__('common.empty_record'),
            'ConfirmDelete' : window.__('common.confirm_delete'),
            'DeleteOperationAlert' : window.__('common.delete_operation_alert'),
            'EditOperationAlert' : window.__('common.edit_operation_alert'),
            'CancelEdit' : window.__('common.cancel_edit'),
            'NoResult' : window.__('common.no_result'),
        },
    }
});