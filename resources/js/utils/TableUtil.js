
/**
 * Created by N0D1R on 14-Jan-20.
 */
"use strict";

export class TableUtil{

    constructor(component) {
        this.component = component;
        this.grid = component.$refs.grid;
        this.registerBtn = component.$refs.registerBtn;
        this.editTitle = component.$refs.editTitle;
        this.editBtn = component.$refs.editBtn;
        this.deleteBtn = component.$refs.deleteBtn;

        this.hideTitle();
        this.disableRegistration();
        this.disableDeleting();
        this.addListeners();

        this.init();

    }

    init(){
        this.grid.setProperties({
            toolbar: [],
            editSettings: {
                allowDeleting: false,
                allowEditing: false,
                allowAdding: false,
                mode : "Batch",
                newRowPosition: 'Bottom',
                ShowConfirmDialog : true,
            },
        });
    }

    addListeners(){
        this.editBtn.addEventListener("click", () => this.beginEditing(), false);
        this.registerBtn.addEventListener("click", ()=> this.register(), false);
        this.deleteBtn.addEventListener("click", ()=> this.delete(), false);
        // Enter key listener to add new row at the bottom
        this.grid.$el.addEventListener('keydown', (e) => {
            if(e.keyCode == 13) {
                this.grid.ej2Instances.addRecord();
            }
        });
        // Mouse click listener to enter cell edit mode
        // this.grid.ej2Instances.element.addEventListener('mousedown', function(e) {
        //     var instance = this.ej2_instances[0];
        //     if (e.target.classList.contains("e-rowcell")) {
        //         let index = parseInt(e.target.getAttribute("Index"));
        //         let colindex = parseInt(e.target.getAttribute("aria-colindex"));
        //         let field = instance.getColumns()[colindex].field;
        //         instance.editModule.editCell(index, field);
        //     }
        // });

    }

    beginEditing(){
        this.endEditing();
        this.grid.setProperties({
            // toolbarClick : (args)=>{
            //     if(args.item.id === 'exit')
            //         this.endEditing()
            // },
            // toolbar: ['Edit','Delete','Update','Cancel',
            //     { text: window.__('common.exit'), tooltipText: window.__('common.exit_from_edit_mode'), prefixIcon: 'exit-btn', id: 'exit' }],
            editSettings: {
                allowDeleting: true,
                allowEditing: true,
                allowAdding: true,
                mode : 'Batch',
                showDeleteConfirmDialog: true,
                newRowPosition: 'Bottom'
            }
        });
        this.showTitle();
        this.enableRegistration();
        this.enableDeleting();
        this.grid.ej2Instances.addRecord();
    }

    endEditing(){
        this.grid.closeEdit();
        this.grid.setProperties({
            toolbar: [],
            editSettings: {
                allowDeleting: false,
                allowEditing: false,
                allowAdding: false,
            },
        });
        this.hideTitle();
        this.disableRegistration();
        this.disableDeleting();
    }

    editFailure(){
        this.grid.startEdit();
    }

    hideTitle(){
        this.editTitle.style.visibility = "hidden";
    }

    showTitle(){
        this.editTitle.style.visibility = "visible";
    }

    disableRegistration(){
        this.registerBtn.disabled = true;
    }

    enableRegistration(){
        this.registerBtn.disabled = false;
    }

    disableDeleting(){
        this.deleteBtn.disabled = true;
    }

    enableDeleting(){
        this.deleteBtn.disabled = false;
    }

    register() {
        this.component.saveChanges(this.grid.ej2Instances.getBatchChanges());
    }

    delete(){
        this.grid.deleteRecord();
        let selectedRow = this.grid.getSelectedRowIndexes()[0];
        if (selectedRow !== undefined) {
            this.component.data.splice(selectedRow, 1);
        }
        console.log(this.component.data);
    }
}
