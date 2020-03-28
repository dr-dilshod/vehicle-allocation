/**
 * Created by N0D1R on 27-Mar-20.
 */
module.exports = {

    data() {
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
                if (this.updatedData.length > 0 || this.addedData.length > 0 || this.deletedData.length > 0) {
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
                this.data[index].delete_flg = 1;
                const duplicate = this.deletedData.filter(el => _.isEqual(el, this.data[index])).length;
                console.log(duplicate);
                if (duplicate === 0) {
                    const deleted = _.cloneDeep(this.data[index]);
                    deleted.delete_flg = 1;
                    this.deletedData.push(deleted);
                    this.selectRow(index);
                } else {
                    this.deletedData = this.deletedData.filter(el => !_.isEqual(el, this.data[index]));
                    this.deselectRow(index, true);
                }
                this.data[index].delete_flg = 0;
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


            if (this.deletedData.length > 0) {
                this.reserveData = this.reserveData.filter(el => {
                    return !this.deletedData.some(({shipper_id}) => shipper_id === el.shipper_id)
                });
                this.updatedData.push(...this.deletedData);
            }

            this.reserveData.forEach((el, idx) => {
                if (!_.isEqual(el, this.data[idx])) {
                    this.updatedData.push(this.data[idx]);
                }
            });

            console.log(this.updatedData);

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
            if (this.deletedData.length > 0) {
                this.$modal.show({
                    template: this.saveChangesTemplate,
                    props: ['title', 'text', 'triggerOnConfirm', 'triggerDiscard']
                }, {
                    title: window.__('alert.message'),
                    text: this.__('common.confirm_delete'),
                    triggerOnConfirm: () => {
                        this.$modal.hide('confirmDialog');
                        this.data = this.data.filter((el) => {
                            return !this.deletedData.some(({shipper_id}) => el.shipper_id === shipper_id)
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
        save(added, updated, modal = false) {
            this.refresh();
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
            if (this.data.length === this.reserveData.length) {
                this.addRow();
            }
        },
        endEditing() {
            this.editMode = false;
        },
        addRow() {
            this.data.push({});
        },
    }

};
