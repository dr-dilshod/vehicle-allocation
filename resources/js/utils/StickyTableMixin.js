/**
 * Created by N0D1R on 27-Mar-20.
 */
module.exports = {

    data(){
        return {
            updatedData: [],
            deletedData: [],
            addedData: [],
            reserveData: [],
            editMode: false,
        }
    },

    mounted() {
        window.onbeforeunload = () => {
            if (this.editMode) {
                this.checkChanges();
                this.checkDeletes();
                if (this.updatedData.length > 0 || this.addedData.length > 0 || this.deletedData.length > 0) {
                    return "stop eee!";
                }
            }

            return null;
        }
    },

    methods : {
        removeEvents() {
            const inputElements = document.querySelectorAll('tr input');
            const selectElements = document.querySelectorAll('tr select');
            inputElements.forEach(el => {
                if (!_.isNil(el)) {
                    el.addEventListener('keydown', (e) => {
                    });
                }
            });

            selectElements.forEach(el => {
                if (!_.isNil(el)) {
                    el.addEventListener('keydown', (e) => {
                    });
                }
            });
        },
        addRowEvent(remove = false) {
            const inputElements = document.querySelectorAll('tr input');
            const selectElements = document.querySelectorAll('tr select');

            this.removeEvents();
            inputElements.forEach(el => {
                if (!_.isNil(el)) {
                    if (remove) {
                        el.addEventListener('keydown', (e) => {
                        });
                    } else {
                        el.addEventListener('keydown', (e) => {
                            if (_.isEqual(e.key, "Enter")) {
                                this.addRow();
                            }
                        });
                    }
                }
            });
            selectElements.forEach(el => {
                if (!_.isNil(el)) {
                    if (remove) {
                        el.addEventListener('keydown', (e) => {
                        });
                    } else {
                        el.addEventListener('keydown', (e) => {
                            if (_.isEqual(e.key, "Enter")) {
                                this.addRow();
                            } else if (_.isEqual(e.key, "Tab") && e.target.classList.contains("last")) {
                                this.addRow();
                            }
                        });
                    }
                }
            });
        },
        clickRow(event, index) {
            if (!(event.target instanceof HTMLTableCellElement)) {
                event.stopPropagation();
                return;
            }
            if (this.editMode) {
                if (this.data[index].delete_flg === 1) {
                    this.data[index].delete_flg = 0;
                    this.deselectRow(index, true);
                } else {
                    this.data[index].delete_flg = 1;
                    this.selectRow(index);
                }
            }
        },
        deselectRow(index){
            let row = document.querySelector(`tr[index="${index}"]`);
            console.log(row);
            if (_.isNull(row)) {
                return;
            }
            row.childNodes.forEach(el => {
                if (el instanceof HTMLTableCellElement) {
                    el.removeAttribute("style");
                }
            })
        },
        selectRow(index){
            let row = document.querySelector(`tr[index="${index}"]`);
            console.log(row);
            if (_.isNull(row)) {
                return;
            }
            row.childNodes.forEach(el => {
                if (el instanceof HTMLTableCellElement) {
                    el.setAttribute("style", "background: #f5d2d2");
                }
            })
        },
        checkDeletes() {
            if (!this.editMode) {
                return;
            }
            this.deletedData = [];
            this.deletedData = this.data.filter(el => el.delete_flg === 1);
        },
        checkChanges() {
            if (!this.editMode) {
                return;
            }
            this.updatedData = [];
            this.addedData = [];

            if (this.data.length > this.reserveData.length) {
                this.addedData = this.data.slice(this.reserveData.length);
                this.addedData = this.addedData.filter(el => {
                    return !_.every(el, _.isEmpty) && !_.isNull(el);
                });
            }
            this.reserveData.forEach((el, idx) => {
                if (!_.isEqual(el, this.data[idx])) {
                    this.updatedData.push(this.data[idx]);
                }
            });
        },
        saveData() {
            if (!this.editMode) {
                return;
            }
            this.checkChanges();
            if (!_.isEmpty(this.updatedData) || !_.isEmpty(this.addedData)) {
                this.$modal.show({
                    template: this.saveChangesTemplate,
                    props: ['title', 'text', 'triggerOnConfirm', 'triggerDiscard']
                }, {
                    title: window.__('alert.message'),
                    text: this.__('common.save_changes'),
                    triggerOnConfirm: () => {
                        this.$modal.hide('confirmDialog');
                        this.save(this.addedData, this.updatedData, true);
                    },
                    triggerDiscard: () => {
                        this.$modal.hide('confirmDialog');
                    }
                }, {
                    height: 'auto',
                    width: 400,
                    name: 'confirmDialog'
                });
            } else {
                this.endEditing();
            }
        },
        deleteSelected() {
            this.checkDeletes();
            if (this.deletedData.length > 0) {
                this.$modal.show({
                    template: this.saveChangesTemplate,
                    props: ['title', 'text', 'triggerOnConfirm', 'triggerDiscard']
                }, {
                    title: window.__('alert.message'),
                    text: this.__('common.save_changes'),
                    triggerOnConfirm: () => {
                        this.$modal.hide('confirmDialog');
                        this.delete(this.deletedData);
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
        save(added, updated, modal = false) {
            axios.post(this.resourceUrl, {added: added, updated: updated})
                .then(resp => {
                    this.refresh();
                    if (modal) {
                        this.showOperationSuccessDialog();
                    }
                }).catch(err => {
                this.errorDialog(err);
            });
        },
        delete(data) {
            axios.post(this.resourceUrl + '/delete', {ids: data})
                .then(resp => {
                    this.refresh();
                    this.showOperationSuccessDialog();
                }).catch(err => {
                this.errorDialog(err);
            });
        },
        toEditMode() {
            this.editMode = true;
            this.addRowEvent();
        },
        endEditing() {
            this.editMode = false;
            this.addRowEvent(true);
        },
        addRow() {
            this.data.push({});
        },
    }

};
