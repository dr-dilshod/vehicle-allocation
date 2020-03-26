<template>
    <div id="app">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl" class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div class="col-2">
                <h2 ref="editTitle" class="text-center text-danger">{{__('common.editing')}}</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{__('shipper.shipper_list')}}</h2>
            </div>
            <div class="col-4">
                <p class="text-right">
                    <button ref="deleteBtn" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.delete')}}
                    </button>
                    <button ref="registerBtn" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.register')}}
                    </button>
                    <button ref="editBtn" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.edit')}}</button>
                </p>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="mx-auto">

                <form action="#" class="form-inline" @submit.prevent="search">
                    <div class="form-group ml-3">
                        <label for="selectedShipper">{{__('shipper.shipper')}}</label>
                    </div>
                    <div class="form-group ml-3">
                        <select id="selectedShipper" v-model="filter.shipper" class="form-control"
                                style="width: 280px;">
                            <option value=""></option>
                            <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                {{ shipper.fullname }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <label for="selectedCompany">{{__('shipper.bill_to')}}</label>
                    </div>
                    <div class="form-group ml-3">
                        <select name="selectedCompany" id="selectedCompany" v-model="filter.billTo" class="form-control"
                                style="width: 280px;">
                            <option value=""></option>
                            <option v-for="company in companies" :value="company">
                                {{ company }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group ml-3">
                        <button type="submit" class="btn btn-primary btn-fixed-width">{{__('common.search')}}</button>
                    </div>
                    <div class="form-group ml-3">
                        <button type="reset" @click="clear" class="btn btn-primary btn-fixed-width">
                            {{__('common.clear')}}
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <button @click="toEditMode" :disabled="editMode"> Edit mode</button>
        <button @click="saveData" :disabled="!editMode">Save</button>
<!--        <button @click="addRow" :disabled="!editMode"> Add row</button>-->
        <button @click="deleteSelected" :disabled="!editMode"> Delete Selected</button>

        <div id="table-scroll" class="table-scroll">
            <table class="table table-hover table-bordered table-custom-inputs">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sticky-col first-sticky-col">Shipper No</th>
                    <th scope="col" class="sticky-col second-sticky-col">Shipper</th>
                    <th scope="col" class="sticky-col third-sticky-col last-sticky-col">Furigana</th>
                    <th scope="col">Company abbr</th>
                    <th scope="col">Postal code</th>
                    <th scope="col">Address1</th>
                    <th scope="col">Address2</th>
                    <th scope="col">Phone number</th>
                    <th scope="col">Fax number</th>
                    <th scope="col">Closing date</th>
                    <th scope="col">Payment date</th>
                    <th scope="col" class="primary-key">Shipper Id</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(shipper, index) in data" :data-key="shipper.shipper_id" ref="tr"
                    @click="selectRow($event,shipper.shipper_id)">
                    <td class="sticky-col first-sticky-col">
                        <input type="text" class="form-control" v-model='shipper.shipper_no' :disabled='!editMode'/>
                    </td>
                    <td class="sticky-col second-sticky-col">
                        <input type="text" class="form-control" v-model="shipper.shipper_name1" :disabled="!editMode"/>
                        <input type="text" class="form-control" v-model="shipper.shipper_name2" :disabled="!editMode"/>
                    </td>
                    <td class="sticky-col third-sticky-col last-sticky-col">
                        <input type="text" class="form-control" v-model="shipper.shipper_kana_name1"
                               :disabled="!editMode"/>
                        <input type="text" class="form-control" v-model="shipper.shipper_kana_name2"
                               :disabled="!editMode"/>
                    </td>
                    <td>
                        <input type="text" class="form-control" v-model="shipper.shipper_company_abbreviation"
                               :disabled="!editMode"/>
                    </td>
                    <td>
                        <input type="text" class="form-control" v-model="shipper.postal_code" :disabled="!editMode"/>
                    </td>
                    <td>
                        <input type="text" class="form-control" v-model="shipper.address1" :disabled="!editMode"/>
                    </td>
                    <td>
                        <input type="text" class="form-control" v-model="shipper.address2" :disabled="!editMode"/>
                    </td>
                    <td>
                        <input type="text" class="form-control" v-model="shipper.phone_number" :disabled="!editMode"/>
                    </td>
                    <td>
                        <input type="text" class="form-control" v-model="shipper.fax_number" :disabled="!editMode"/>
                    </td>
                    <td>
                        <select class="form-control" v-model="shipper.closing_date" :disabled="!editMode">
                            <option v-for="option in closingDateOptions" v-bind:value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </td>
                    <td>
                        <input type="date" :class="data.length-1 == index ? 'form-control last': 'form-control'"
                               v-model="shipper.payment_date" :disabled="!editMode"/>
                    </td>
                    <td class="primary-key">
                        <input type="text" class="form-control" v-model="shipper.shipper_id" :disabled="!editMode"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>
<script>
    import Vue from "vue";
    import {en, ja} from 'vuejs-datepicker/dist/locale'

    export default {
        props: {
            backUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
        },
        data() {
            return {
                data: [],
                updatedData: [],
                deletedData: [],
                addedData: [],
                reserveData: [],
                companies: [],
                shippers: [],
                editMode: false,
                filter: {
                    shipper: '',
                    billTo: ''
                },
                options: {
                    monthFormat: "yyyy/MM",
                    weekday: "yyyy-MM-dd",
                    language: {
                        en: en,
                        ja: ja
                    },
                },
                closingDateOptions: [
                    {value: "0", text: __("shipper.closing_date_combo.option1")},
                    {value: "1", text: __("shipper.closing_date_combo.option2")},
                    {value: "2", text: __("shipper.closing_date_combo.option3")},
                ],
            }
        },
        mounted() {
            this.fetchShipperNames();
            this.fetchCompanies();
            this.search();

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
        methods: {
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
            selectRow(event, id) {
                if (!(event.target instanceof HTMLTableCellElement)) {
                    event.stopPropagation();
                    return;
                }
                if (this.editMode) {
                    this.data.map(el => {
                        if (_.isEqual(el.shipper_id, id)) {
                            if (el.delete_flg === 1) {
                                el.delete_flg = 0;
                                this.setSelected(`tr[data-key="${id}"]`, true);
                            } else {
                                el.delete_flg = 1;
                                this.setSelected(`tr[data-key="${id}"]`, false);
                            }
                        }
                        return el;
                    });
                }
            },
            setSelected(selector, unset = false) {
                const element = document.querySelector(selector);
                if (_.isNull(element)) {
                    return;
                }
                if (unset) {
                    element.childNodes.forEach(el => {
                        if (el instanceof HTMLTableCellElement) {
                            el.removeAttribute("style");
                        }
                    })
                } else {
                    element.childNodes.forEach(el => {
                        if (el instanceof HTMLTableCellElement) {
                            el.setAttribute("style", "background: #f5d2d2");
                        }
                    })
                }
            },
            fetchShipperNames() {
                let url = this.resourceUrl + '/fullname';
                axios.get(url)
                    .then(response => {
                        this.shippers = response.data;
                    });
            },
            fetchCompanies() {
                let url = this.resourceUrl + '/distinct-company';
                axios.get(url)
                    .then(response => {
                        this.companies = response.data
                    });
            },
            search() {
                axios.post(this.resourceUrl + '/filter', this.filter)
                    .then(response => {
                        this.data = response.data;
                        this.reserveData = _.cloneDeep(response.data);
                    })
            },
            clear() {
                this.filter = {
                    shipper: '',
                    billTo: '',
                };
            },
            refresh() {
                document.querySelectorAll('tr[data-key]').forEach(tr => {
                    tr.childNodes.forEach(el => {
                        if (el instanceof HTMLTableCellElement) {
                            el.removeAttribute("style");
                        }
                    })
                });
                this.editMode = false;
                this.clear();
                this.fetchShipperNames();
                this.fetchCompanies();
                this.search();
            },
            checkDeletes() {
                if (!this.editMode) {
                    return;
                }
                this.deletedData = [];
                this.deletedData = this.data.filter(el => el.delete_flg === 1).map(el => {
                    return el.shipper_id;
                });
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
                            this.saveShippers(this.addedData, this.updatedData, true);
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
                            this.deleteShippers(this.deletedData);
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
            saveShippers(added, updated, modal = false) {
                axios.post(this.resourceUrl, {addedShippers: added, updatedShippers: updated})
                    .then(resp => {
                        this.refresh();
                        if (modal) {
                            this.showOperationSuccessDialog();
                        }
                    }).catch(err => {
                    this.errorDialog(err);
                });
            },
            deleteShippers(data) {
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
                this.data.push({
                    shipper_no: '',
                    shipper_name1: '',
                    shipper_name2: '',
                    shipper_kana_name1: '',
                    shipper_kana_name2: '',
                    shipper_company_abbreviation: '',
                    postal_code: '',
                    address1: '',
                    phone_number: '',
                    fax_number: '',
                    closing_date: null,
                    payment_date: null,
                    shipper_id: null,
                });
            },
        },
        name: 'ShipperList'
    }

</script>
