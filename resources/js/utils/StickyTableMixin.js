/**
 * Created by N0D1R on 27-Mar-20.
 */
module.exports = {

    data() {
        return {
            reserveData: [],
            selectedItems: [],
            editMode: false,
        }
    },

    mounted() {
        window.onbeforeunload = () => {
            if (this.editMode) {
                if (this.isDataChanged()) {
                    return "stop eee!";
                }
            }

            return null;
        }
    },

    methods: {
        addRowOnChange(event) {
            if (event.target.parentNode.parentNode.isSameNode(document.querySelector('tbody tr:last-child'))) {
                this.addRow();
            }
        },
        clickRow(event, index) {
            if (!(event.target instanceof HTMLTableCellElement)) {
                event.stopPropagation();
                return;
            }
            if (this.editMode) {
                const place = this.selectedItems.indexOf(index);
                if (place > -1) {
                    this.selectedItems.splice(place, 1);
                    this.deselectRow(index);
                } else {
                    this.selectedItems.push(index);
                    this.selectRow(index);
                }
            }
        },
        deselectRow(index) {
            let row = document.querySelector(`tr[index="${index}"]`);
            if (_.isNull(row)) {
                return;
            }
            row.childNodes.forEach(el => {
                if (el instanceof HTMLTableCellElement) {
                    el.removeAttribute("style");
                }
            })
        },
        deselectAll() {
            this.data.forEach((el, idx) => {
                if (!_.isNil(el)) {
                    this.deselectRow(idx);
                }
            });
            this.selectedItems = [];
        },
        selectRow(index) {
            let row = document.querySelector(`tr[index="${index}"]`);
            if (_.isNull(row)) {
                return;
            }
            row.childNodes.forEach(el => {
                if (el instanceof HTMLTableCellElement) {
                    el.setAttribute("style", "background: #f5d2d2");
                }
            })
        },
        isDataChanged() {
            let copy = _.cloneDeep(this.data);
            copy = copy.filter(el => {
               return !_.every(el, _.isEmpty) && !_.every(el, _.isNil);
            });
            return JSON.stringify(copy) !== JSON.stringify(this.reserveData);
        },

        saveConfirmModal() {
            if (!this.isDataChanged()) {
                this.data = _.cloneDeep(this.reserveData);
                this.endEditing();
                this.deselectAll();
                return;
            }
            this.$modal.show({
                template: this.saveChangesTemplate,
                props: ['title', 'text', 'triggerOnConfirm', 'triggerDiscard']
            }, {
                title: window.__('alert.message'),
                text: this.__('common.save_changes'),
                triggerOnConfirm: () => {
                    this.$modal.hide('confirmDialog');
                    this.save();
                },
                triggerDiscard: () => {
                    this.$modal.hide('confirmDialog');
                }
            }, {
                height: 'auto',
                width: 400,
                name: 'confirmDialog'
            });

        },
        deleteConfirmModal() {
            if (this.selectedItems.length > 0) {
                this.$modal.show({
                    template: this.saveChangesTemplate,
                    props: ['title', 'text', 'triggerOnConfirm', 'triggerDiscard']
                }, {
                    title: window.__('alert.message'),
                    text: this.__('common.confirm_delete'),
                    triggerOnConfirm: () => {
                        this.$modal.hide('confirmDialog');
                        this.selectedItems.forEach(index => {
                            this.data[index].delete_flg = 1;
                        });
                        this.deselectAll();
                    },
                    triggerDiscard: () => {
                        this.$modal.hide('confirmDialog');
                    }
                }, {
                    height: 'auto',
                    width: 400,
                    name: 'confirmDialog'
                });
            }
        },
        save() {
            this.data.splice(this.data.length - 1);
            axios.post(this.resourceUrl, this.data)
                .then(resp => {
                    this.refresh();
                    this.showOperationSuccessDialog();
                }).catch(err => {
                this.errorDialog(err);
            });
        },
        toEditMode() {
            this.editMode = true;
            if (this.data.length === this.reserveData.length) {
                this.addRow();
            }
        },
        endEditing() {
            this.editMode = false;
        },
        addRow() {
            this.data.push(this.emptyRow);
        },
        resetTable(response) {
            this.reserveData = _.cloneDeep(response.data);
            this.deselectAll();
        }
    }

};
