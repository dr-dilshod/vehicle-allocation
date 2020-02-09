
/**
 * Created by N0D1R on 14-Jan-20.
 */
"use strict";

export class TableUtil{

    constructor(component) {
        this.grid = component.$refs.grid;
        this.registerBtn = component.$refs.registerBtn;
        this.editTitle = component.$refs.editTitle;
        this.editBtn = component.$refs.editBtn;

        this.hideTitle();
        this.disableRegistration();
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
            },
        });
    }

    addListeners(){
        this.editBtn.addEventListener("click", () => this.beginEditing(), false);
        this.registerBtn.addEventListener("click", ()=> this.register(), false);
    }

    beginEditing(){
        this.grid.setProperties({
            toolbarClick : (args)=>{
                if(args.item.id === 'exit')
                    this.endEditing()
            },
            toolbar: [
                {text:window.__('common.cancel'),tooltipText:window.__('common.cancel_mode'), prefixIcon: 'cancel-btn', id: 'cancel'},
                {text:window.__('common.update'),tooltipText:window.__('common.update_mode'), prefixIcon: 'update-btn', id: 'update'},
                {text:window.__('common.delete'),tooltipText:window.__('common.delete_mode'), prefixIcon: 'delete-btn', id: 'delete'},
                {text:window.__('common.edit'),tooltipText:window.__('common.edit_mode'), prefixIcon: 'edit-btn', id: 'edit'},
                { text: window.__('common.exit'), tooltipText: window.__('common.exit_from_edit_mode'), prefixIcon: 'exit-btn', id: 'exit' }],
            editSettings: {
                allowDeleting: true,
                allowEditing: true,
                allowAdding: true,
                showDeleteConfirmDialog: true,
            },
        });
        this.showTitle();
        this.enableRegistration();
    }

    toolbarClickHandler(args){
        let self = this;
        if (args.item.id === 'exit') {
            self.endEditing();
        }
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

    register() {
        this.grid.addRecord();
    }
}