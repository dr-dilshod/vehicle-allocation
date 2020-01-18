
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

    }

    addListeners(){
        this.editBtn.addEventListener("click", () => this.beginEditing(), false);
        this.registerBtn.addEventListener("click", ()=> this.register(), false);
    }

    beginEditing(){
        this.grid.setProperties({
            toolbar: ['Edit','Delete','Update','Cancel'],
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