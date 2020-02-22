<template>
    <form action="#" @submit.prevent="register">
        <div id="item-registration">
            <div class="row">
                <div class="col-2">
                    <button type="submit" @click.prevent="back"
                       class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</button>
                </div>
                <div class="col-2">
                    <h6 class="text-center text-danger">* {{__('common.edit')}}</h6>
                </div>
                <div class="col-4">
                    <h2 class="text-center">{{title}}</h2>
                </div>
                <div class="col-4">
                    <p class="text-right">
                        <button type="submit" class="btn btn-lg btn-danger btn-fixed-width">{{operation}}</button>
                        <button type="reset" class="btn btn-lg btn-danger btn-fixed-width" @click.prevent="clear">
                            {{clearing}}
                        </button>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-9">
                    <br>
                    <table>
                        <tbody class="list">
                        <tr>
                            <td class="text-right" width="15%">
                                <span class="required"> *</span>
                                <label for="stack_date">{{__('item.stack_date')}}</label>
                            </td>
                            <td width="25%">
                                <datepicker v-model="itemData.stack_date" id="stack_date" name="stack_date" :bootstrap-styling="true" v-on:change="notify"
                                           :typeable="true" :format="options.weekday" :clear-button="true" :language="options.language.ja"
                                ></datepicker>
                            </td>
                            <td width="5%"></td>
                            <td class="text-right" width="15%">
                                <span class="required">*</span>
                                <label for="stack_time_hour">{{__('item.stack_time')}}</label>
                            </td>
                            <td class="stack_time_hour" width="10%">
                                <select name="stack_time_hour" id="stack_time_hour" v-model="stack_time_hour"
                                        v-on:input="timeFormatter" class="form-control" required>
                                    <option v-for="hour in getEnumerationHours()" :value="hour">
                                        {{ hour }}
                                    </option>
                                </select>
                            </td>
                            <th width="3%" class="text-center"><span>:</span></th>
                            <td width="10%">
                                <select name="stack_time_min" id="stack_time_min" v-model="stack_time_min"
                                        v-on:input="timeFormatter" class="form-control" required>
                                    <option v-for="min in getEnumerationMins()" :value="min">
                                        {{ min }}
                                    </option>
                                </select>
                            </td>
                            <td width="10%" class="text-right"><label for="billing">{{__('item.invoice')}}</label></td>
                            <td width="7%" class="text-center">
                                <input type="checkbox" name="down_invoice" id="billing" v-on:click="setMandatory"
                                       v-model="itemData.down_invoice" ref="invoice">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <span class="required"> *</span>
                                <label for="down_date">{{__('item.down_date')}}</label>
                            </td>
                            <td>
                                <datepicker v-model="itemData.down_date" id="down_date" name="down_date" :bootstrap-styling="true" v-on:change="notify"
                                            :typeable="true" :format="options.weekday" :clear-button="true" :language="options.language.ja"
                                ></datepicker>
                            </td>
                            <td></td>
                            <td class="text-right">
                                <span class="required"> *</span>
                                <label for="down_time_hour">{{__('item.down_time')}}</label>
                            </td>
                            <td>
                                <select name="down_time_hour" id="down_time_hour" v-model="down_time_hour"
                                        v-on:input="timeFormatter" class="form-control" required>
                                    <option v-for="hour in getEnumerationHours()" :value="hour">
                                        {{ hour }}
                                    </option>
                                </select>
                            </td>
                            <th class="text-center">
                                <span class="">:</span>
                            </th>
                            <td>
                                <select name="down_time_min" id="down_time_min" v-model="down_time_min"
                                        v-on:input="timeFormatter" class="form-control" required>
                                    <option v-for="min in getEnumerationMins()" :value="min">
                                        {{ min }}
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <span class="required"> *</span>
                                <label for="vehicle_model">{{__('item.vehicle_model')}}</label>
                            </td>
                            <td>
                                <select name="vehicle_model" id="vehicle_model" v-model="vehicle_model" @change="calcUnitPrice"
                                        class="form-control" required>
                                    <option value=""></option>
                                    <option>{{__('item.wing')}}</option>
                                    <option>{{__('item.flat')}}</option>
                                    <option>{{__('item.trailer')}}</option>
                                    <option>{{__('item.bulk')}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <span class="required"> *</span>
                                <label for="shipper_id">{{__('item.shipper')}}</label>
                            </td>
                            <td>
                                <select name="shipper" id="shipper_id" v-model="itemData.shipper_id"
                                        class="form-control" v-on:change="setShipperName" required>
                                    <option value=""></option>
                                    <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                        {{ shipper.shipper_name1 + " " + shipper.shipper_name2}}
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <span class="required"> *</span>
                                <label for="stack_point">{{__('item.stack_point')}}</label>
                            </td>
                            <td>
                                <input type="text" placeholder="" class="form-control" v-on:focusout="calcUnitPrice" v-on:change="notify"
                                       v-model="itemData.stack_point" id="stack_point" required/>
                            </td>
                            <td class="text-center">~</td>
                            <td class="text-right">
                                <span class="required"> *</span>
                                <label for="down_point">{{__('item.down_point')}}</label>
                            </td>
                            <td colspan="3">
                                <input id="down_point" for="down_point" type="text" placeholder=""
                                       class="form-control" v-on:focusout="calcUnitPrice" v-on:change="notify"
                                       v-model="itemData.down_point" required/>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <label for="weight">{{__('item.number_t')}}</label>
                            </td>
                            <td>
                                <input id="weight" type="text" placeholder="" class="form-control"
                                      v-on:input="setWeight" v-model="itemData.weight"/>
                            </td>
                            <td class="text-center">t</td>
                            <td class="text-right">
                                <label for="empty_pl">{{__('item.empty_pl')}}</label>
                            </td>
                            <td colspan="2">
                                <select name="empty_pl" id="empty_pl" v-model="itemData.empty_pl"
                                        class="form-control" v-on:change="notify">
                                    <option value=""></option>
                                    <option value="1">{{__('item.yes')}}</option>
                                    <option value="0">{{__('item.none')}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><label for="per_ton">{{__('item.per_ton')}}</label></td>
                            <td>
                                <input id="per_ton" type="text" placeholder="" class="form-control"
                                       v-model="per_ton" v-on:change="notify"/>
                            </td>
                            <td class="text-center">{{__('item.yen')}}</td>
                            <td><span class="text-center">x</span></td>
                            <td colspan="3">
                                <input type="text" placeholder="" class="form-control" id="ton"
                                       v-model="ton" value="" v-on:change="notify"/>
                            </td>
                            <td><span class="text-right">t</span></td>
                        </tr>
                        <tr>
                            <td class="text-right"><label for="per_vehicle">{{__('item.per_vehicle')}}</label></td>
                            <td>
                                <input type="text" placeholder="" class="form-control" id="per_vehicle"
                                       v-on:input="perVehicleChange" :disabled="isDisabled" v-model="per_vehicle"/>
                            </td>
                            <td class="text-center">{{__('item.yen')}}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><label for="item_price">{{__('item.amount_of_money')}}</label></td>
                            <td>
                                <input type="text" placeholder="" class="form-control" id="item_price"
                                       v-model="itemData.item_price" value="" readonly/>
                            </td>
                            <td class="text-center">{{__('item.yen')}}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><label for="vehicle_no3">{{__('item.vehicle_no')}}</label></td>
                            <td>
                                <input type="text" placeholder="" class="form-control" id="vehicle_no3" v-on:change="notify"
                                       v-model="itemData.vehicle_no3"/>
                            </td>
                            <td></td>
                            <td class="text-right"><label for="driver_id">{{__('item.driver_name')}}</label></td>
                            <td colspan="3">
                                <select name="driver_id" id="driver_id" v-on:change="setDriverName"
                                        v-model="itemData.driver_id" class="form-control">
                                    <option value=""></option>
                                    <option v-for="driver in drivers" :value="driver.driver_id">
                                        {{ driver.driver_name }}
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <span ref= "editMandatory" class="required"> *</span>
                                <label for="chartered_vehicle">{{__('item.chartered_vehicle')}}</label>
                            </td>
                            <td>
                                <select name="chartered_vehicle" id="chartered_vehicle" v-on:change="setVehicleName"
                                        v-model="itemData.vehicle_id" class="form-control" ref="chartered_vehicle">
                                    <option value=""></option>
                                    <option v-for="vehicle in vehicles" :value="vehicle.vehicle_id">
                                        {{ vehicle.company_name }}
                                    </option>
                                </select>
                            </td>
                            <td></td>
                            <td class="text-right">
                                <label for="vehicle_payment">{{__('item.rental_vehicle_payment')}}</label>
                            </td>
                            <td colspan="2">
                                <input type="text" class="form-control" id="vehicle_payment" v-on:change="notify"
                                       v-model="itemData.vehicle_payment"/>
                            </td>
                            <td><span class="text-right">{{__('item.yen')}}</span></td>
                        </tr>
                        <tr>
                            <td class="text-right"><label for="item_remark">{{__('item.remarks')}}</label></td>
                            <td colspan="6">
                                <textarea rows="3" class="form-control" id="item_remark" v-on:change="notify"
                                      v-model="itemData.item_remark"></textarea>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import Datepicker from "vuejs-datepicker";
    import {en, ja} from 'vuejs-datepicker/dist/locale'

    export default {
        components: {
            Datepicker
        },
        props: {
            backUrl: {type: String, required: true},
            shipperUrl: {type: String, required: true},
            driverUrl: {type: String, required: true},
            vehicleUrl: {type: String, required: true},
            unitPriceUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
            redirectUrl: {type: String, required: true},
            title: {type: String, required: true},
            operation: {type: String, required: true},
            clearing: {type: String, required: true},
            itemId: {type: String},
            mode: {type: String},
        },
        data() {
            return {
                itemData: {
                    item_id: '',
                    shipper_id: '',
                    driver_id: '',
                    vehicle_id: '',
                    status: 0,
                    stack_date: '',
                    stack_time: '',
                    down_date: '',
                    down_time: '',
                    down_invoice: '',
                    stack_point: '',
                    down_point: '',
                    weight: '',
                    empty_pl: '',
                    item_price: '',
                    item_driver_name: '',
                    vehicle_no3: '',
                    shipper_name: '',
                    item_vehicle: '',
                    vehicle_payment: '',
                    item_completion_date: '',
                    item_remark: '',
                    delete_flg: 0,
                    create_id: '',
                    update_id: '',
                    remember_token: '',
                },
                isDisabled: false,
                shippers: [],
                drivers: [],
                vehicles: [],
                per_ton: '',
                per_vehicle: '',
                ton: '',
                anyFieldChanged: 0,
                stack_time_hour: '',
                stack_time_min: '',
                down_time_hour: '',
                down_time_min: '',
                vehicle_model: '',
                options: {
                    monthFormat: "yyyy/MM",
                    weekday: "yyyy/MM/dd",
                    language: {
                        en: en,
                        ja: ja
                    },
                },
            }
        },
        mounted() {
            this.fetchShippers(this.shipperUrl);
            this.fetchDrivers(this.driverUrl);
            this.fetchVehicles(this.vehicleUrl);
            this.hideMandatory();
            if (this.itemId !== undefined)
                this.fetchEditData();
        },

        methods: {
            notify() {
                this.anyFieldChanged = 1;
            },
            fetchEditData(){
                axios.get(this.resourceUrl + "/" + this.itemId)
                    .then(response => {
                        this.itemData = response.data;
                        let stack_time = response.data.stack_time.split(":");
                        let down_time = response.data.down_time.split(":");
                        this.stack_time_hour = stack_time[0];
                        this.stack_time_min = stack_time[1];
                        this.down_time_hour = down_time[0];
                        this.down_time_min = down_time[1];
                    });
            },
            setDriverName() {
                this.anyFieldChanged = 1;
                for (let i = 0; i < this.drivers.length; i++) {
                    if (this.itemData.driver_id === this.drivers[i].driver_id) {
                        this.itemData.item_driver_name = this.drivers[i].driver_name;
                        this.itemData.vehicle_no3 = this.drivers[i].vehicle_no3;
                    }
                }
            },
            setShipperName() {
                this.anyFieldChanged = 1;
                for (let i = 0; i < this.shippers.length; i++) {
                    if (this.itemData.shipper_id === this.shippers[i].shipper_id) {
                        this.itemData.shipper_name = this.shippers[i].shipper_name1 + " " + this.shippers[i].shipper_name2;
                        break;
                    }
                }
                this.calcUnitPrice();
            },
            setVehicleName() {
                this.anyFieldChanged = 1;
                for (let i = 0; i < this.vehicles.length; i++) {
                    if (this.itemData.vehicle_id === this.vehicles[i].vehicle_id) {
                        this.itemData.item_vehicle = this.vehicles[i].company_name;
                    }
                }
            },
            setWeight() {
                this.anyFieldChanged = 1;
                this.ton = this.itemData.weight;
            },
            perTonChange() {
                this.anyFieldChanged = 1;
                if(this.per_ton === '' && this.ton === '') {
                    document.getElementById('per_vehicle').disabled = false;
                } else {
                    document.getElementById('per_vehicle').disabled = true;
                }
                this.calcItemPrice();
            },
            calcItemPrice(){
                this.anyFieldChanged = 1;
                if(this.per_ton !== '' && this.ton !== ''){
                    this.itemData.item_price = this.per_ton * this.ton;
                } else
                    if(this.per_vehicle !== ''){
                        this.itemData.item_price = this.per_vehicle;
                    }
            },
            calcUnitPrice() {
                this.anyFieldChanged = 1;
                let component = this;
                if ((this.vehicle_model!=='') && (this.itemData.shipper_id!=='')
                && (this.itemData.stack_point!=='') && (this.itemData.down_point!=='')) {
                    axios.get(this.unitPriceUrl + '?vehicle_model=' + this.vehicle_model
                        + '&shipper_id=' + this.itemData.shipper_id
                        + '&stack_point=' + this.itemData.stack_point
                        + '&down_point=' + this.itemData.down_point)
                            .then(response => {
                                if(response.data.price !== undefined){
                                    component.per_ton = response.data.price;
                                }else{
                                    component.per_ton = '';
                                }
                                component.calcItemPrice();
                            });
                    }
            },
            perVehicleChange() {
                this.anyFieldChanged = 1;
                if (this.per_vehicle == '') {
                    document.getElementById('per_ton').disabled = false;
                    document.getElementById('ton').disabled = false;
                } else {
                    document.getElementById('per_ton').disabled = true;
                    document.getElementById('ton').disabled = true;
                    this.itemData.item_price = this.per_vehicle;
                }
            },
            timeFormatter() {
                this.anyFieldChanged = 1;
                this.itemData.stack_time = document.getElementById('stack_time_hour').value
                    + ':' + document.getElementById('stack_time_min').value;
                this.itemData.down_time = document.getElementById('down_time_hour').value
                    + ':' + document.getElementById('down_time_min').value;
            },
            clear(){
                if (this.itemId !== undefined) {
                this.$fire({
                        title: this.__('common.confirm_delete'),
                        text: this.__('common.cant_be_undone'),
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: this.__('common.ok'),
                        cancelButtonText: this.__('common.cancel')
                    }).then((result) => {
                        if (result.value) {
                            this.deleteItem(this.itemData.item_id);
                        }
                    });
                } else {
                    for (let i in this.itemData) {
                        this.itemData[i] = "";
                    }
                    this.vehicle_model = "";
                    this.per_ton = "";
                    this.per_vehicle = "";
                    this.ton = "";
                    this.stack_time_hour = "";
                    this.stack_time_min = "";
                    this.down_time_hour = "";
                    this.down_time_min = "";
                }
            },
            back(){
                if (this.itemId !== undefined && this.anyFieldChanged == 1) {
                    this.$fire({
                        title: '編集のキャンセル。',
                        text: '編集中のデータを破棄して前の画面に戻りますか？',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: this.__('common.ok'),
                        cancelButtonText: this.__('common.cancel')
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = this.redirectUrl
                        }
                    });
                } else {
                    window.location.href = this.backUrl;
                }
            },
            fetchShippers(url) {
                axios.get(url)
                    .then(shippers => {
                        this.shippers = shippers.data
                    });
            },
            fetchDrivers(url) {
                axios.get(url)
                    .then(response => {
                        this.drivers = response.data
                    });
            },
            fetchVehicles(url) {
                axios.get(url)
                    .then(response => {
                        this.vehicles = response.data
                    });
            },
            register(){
                const itemReg = this;
                if(typeof this.itemData.stack_date == "object" && this.itemData.stack_date !== '')
                    this.itemData.stack_date = this.itemData.stack_date.toISOString().slice(0,10);
                if(typeof this.itemData.down_date == "object" && this.itemData.down_date !== '')
                    this.itemData.down_date = this.itemData.down_date.toISOString().slice(0,10);
                // check whether it is update or create operation
                if (this.itemId === undefined) {
                    // create a new item if it is create operation
                    axios.post(this.resourceUrl, this.itemData)
                        .then(function (response) {
                            itemReg.showSuccessDialog();
                        })
                        .catch(function (error) {
                            itemReg.showDialog(error.response.data);
                            return false;
                        });
                    return true;
                } else {
                    // update that item if it is update operation
                    this.updateItem(this.itemData);

                }
            },
            updateItem(item){
                let id = item.item_id;
                const itemRegistration = this;
                axios.put(this.resourceUrl + '/' + id, item)
                    .then(function (response) {
                        itemRegistration.showSuccessDialog();
                    })
                    .catch(function (error) {
                        itemRegistration.showDialog(error.response.data);
                    });
            },
            deleteItem(item_id){
                const itemRegistration = this;
                axios.delete(this.resourceUrl + '/' + item_id)
                    .then(function (response) {
                        itemRegistration.showSuccessDialog();
                    })
                    .catch(function (error) {
                        itemRegistration.showDialog(error.response.data);
                        return false;
                    });
                return true;
            },
            showDialog(response) {
                let message = response.message + ': ';
                let errors = response.errors;
                $.each(errors, function (key, value) {
                    message += value[0]; //showing only the first error.
                });
                this.$alert(message);
            },
            getEnumerationHours(){
                return ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14'
                    , '15', '16', '17', '18', '19', '20', '21', '22', '23'];
            },
            getEnumerationMins(){
                return ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14'
                    , '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'
                    , '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '44', '45', '46', '47', '48', '49',
                    '50', '51', '52', '53', '54', '55', '56', '57', '58', '59'];
            },
            setMandatory() {
                this.anyFieldChanged = 1;
                if(this.$refs.invoice.checked == true) {
                    this.showMandatory();
                }
                 else {
                    this.hideMandatory();
                }
            },
            hideMandatory(){
                this.$refs.editMandatory.style.visibility = "hidden";
                this.$refs.chartered_vehicle.required = false;
            },

            showMandatory(){
                this.$refs.editMandatory.style.visibility = "visible";
                this.$refs.chartered_vehicle.required = true;
            },
            showSuccessDialog() {
                this.$fire({
                    title:  this.__('messages.info_message'),
                    text: (this.__('item.operation_is_successful')),
                    type: "success",
                    timer: 5000
                }).then(r => {
                    window.location.href = this.redirectUrl;
                });
            },
        },
        watch: {
            per_ton: function () {
                this.perTonChange();
            },
            ton: function () {
                this.perTonChange();
            },
        },
        name : 'ItemRegistration'
    }
</script>
<style>
    .required {
        color: red;
    }
    #item-registration td{
        padding-top: 0.5rem;
    }
</style>
