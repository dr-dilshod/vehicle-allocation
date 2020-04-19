<template>
    <div id="app">
        <div class="row">
            <div class="col-2">
                <a v-on:click="back"
                   class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div class="col-2">
                <h2 class="text-center text-danger" :hidden="!editMode">{{__('common.editing')}}</h2>
            </div>
            <div class="col-3">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-5">
                <p class="text-right">
                    <button class="btn btn-lg btn-danger btn-fixed-width" @click="saveConfirmModal"
                            :disabled="!editMode">{{__('common.register')}}
                    </button>
                    <button class="btn btn-lg btn-danger btn-fixed-width" @click="toEditMode" :disabled="editMode">
                        {{__('common.edit')}}
                    </button>
                    <button class="btn btn-lg btn-danger btn-fixed-width" @click="deleteConfirmModal"
                            :disabled="!editMode">{{__('common.delete')}}
                    </button>
                </p>
            </div>
        </div>
        <div class="row align-items-center mt-4">
            <div class="col-md-9 offset-1">
                <div class="form-row form-horizontal">
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="shipperSelect"
                                   class="col-4 col-form-label ">{{__('unit_prices.shipper')}}</label>
                            <div class="col-8">
                                <select name="shipper" id="shipperSelect" ref="shipperSelect" class="form-control">
                                    <option value="0"></option>
                                    <option v-for="shipper in shippers" :value="shipper.id">
                                        {{shipper.shipper}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button :disabled="editMode" v-on:click="search(true)"
                                    class="btn btn-lg btn-primary btn-block p-1 btn-fixed-width">
                                {{__('common.search')}}
                            </button>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button :disabled="editMode" v-on:click="clear" class="btn btn-lg btn-primary btn-block p-1 btn-fixed-width">
                                {{__('common.clear')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="table-scroll" class="table-scroll">
            <table class="table table-custom-inputs" style="min-width: 1000px;">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sticky-col first-sticky-col">{{__('unit_prices.car_type')}}</th>
                    <th scope="col" class="sticky-col second-sticky-col">{{__('unit_prices.shipper')}}</th>
                    <th scope="col" class="sticky-col third-sticky-col last-sticky-col">
                        {{__('unit_prices.loading_port')}}
                    </th>
                    <th scope="col">{{__('unit_prices.drop_off')}}</th>
                    <th scope="col">{{__('unit_prices.type')}}</th>
                    <th scope="col">{{__('unit_prices.unit_price')}}</th>
                    <th scope="col" class="primary-key">Shipper Id</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(unitPrice, index) in data" :data-key="unitPrice.price_id" :index="index"
                    :hidden="unitPrice.delete_flg == 1"
                    v-on:click="clickRow($event, index)">
                    <td class="sticky-col first-sticky-col">
                        <select v-on:change="addRowOnChange" class="form-control" v-model="unitPrice.car_type"
                                :disabled="!editMode">
                            <option v-for="vehicleType in vehicle_types" :value="vehicleType"
                                    :selected="unitPrice.car_type === vehicleType">{{vehicleType}}
                            </option>
                        </select>
                    </td>
                    <td class="sticky-col second-sticky-col">
                        <select v-on:change="addRowOnChange" class="form-control" v-model="unitPrice.shipperId"
                                :disabled="!editMode">
                            <option
                                v-for="shipper in allShippers"
                                :value="shipper.id" :selected="unitPrice.shipperId === shipper.id">{{shipper.shipper}}
                            </option>
                        </select>
                    </td>
                    <td class="sticky-col third-sticky-col last-sticky-col">
                        <input v-on:change="addRowOnChange" type="text" v-model="unitPrice.stack_point"
                               class="form-control" :disabled="!editMode"/>
                    </td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" v-model="unitPrice.down_point"
                               class="form-control" :disabled="!editMode"/>
                    </td>
                    <td>
                        <select v-on:change="addRowOnChange" class="form-control" v-model="unitPrice.type"
                                :disabled="!editMode">
                            <option value=""></option>
                            <option value="t" :selected="_.isEqual(unitPrice.type, 't')">t</option>
                            <option value="台" :selected="_.isEqual(unitPrice.type, '台')">台</option>
                        </select>
                    </td>
                    <td>
                        <money v-on:change="addRowOnChange" type="text" class="form-control"
                               v-model="unitPrice.price" v-bind="money" :disabled="!editMode"/>
                    </td>
                    <td class="primary-key">
                        <input type="text" class="form-control" v-model="unitPrice.price_id" :disabled="!editMode"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import Vue from "vue";
    import {Money} from 'v-money'
    import StickTableMixin from "../utils/StickyTableMixin";

    export default {
        components: {Money},
        mixins: [
            StickTableMixin
        ],
        name: "UnitPriceTable",
        props: {
            backUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
            title: {type: String, required: true}
        },
        data() {
            return {
                money: {
                    thousands: ',',
                    prefix: '¥',
                    precision: 0,
                    masked: false
                },
                mode: 'normal',
                shippers: [],
                allShippers: [],
                vehicle_types: [
                    this.__('unit_prices.car_types.wing'),
                    this.__('unit_prices.car_types.flat'),
                    this.__('unit_prices.car_types.trailer'),
                    this.__('unit_prices.car_types.bulk'),

                ],
                data: [],
                emptyRow: {
                    price_id: '',
                    car_type: '',
                    shipperId: '',
                    shipper_id: '',
                    stack_point: '',
                    down_point: '',
                    type: '',
                    price: '',
                    delete_flg: 0
                }
            }
        },
        created() {
            this.fetchShipperNames(`${this.resourceUrl}/shipper-names`);
            this.fetchShipperNames(`${this.resourceUrl}/all-shippers`, true);
        },
        mounted() {
            this.search();
        },
        methods: {
            back() {
                if (this.isDataChanged()) {
                    this.confirmBack();
                } else {
                    window.location = this.backUrl;
                }
            },
            search(withShipper = false) {
                let query = '';
                if (withShipper) {
                    let id = this.$refs.shipperSelect.value;
                    query = `?shipper_id=${id}`;
                }
                axios.get(`${this.resourceUrl}/${query}`)
                    .then(response => {
                        if (response.data && response.data.length > 0) {
                            this.data = response.data.map(e => {
                                return {
                                    price_id: e.price_id,
                                    car_type: e.car_type,
                                    shipperId: e.shipper_id,
                                    shipper_id: !_.isNil(e.shipper.shipper_name1) ? e.shipper.shipper_name1 : '' + ' ' + !_.isNil(e.shipper.shipper_name2) ? e.shipper.shipper_name2 : '',
                                    stack_point: e.stack_point,
                                    down_point: e.down_point,
                                    type: e.type,
                                    price: e.price,
                                    delete_flg: e.delete_flg
                                };
                            });
                            this.reserveData = _.cloneDeep(this.data);
                        } else {
                            this.data = [];
                        }
                    });
            },
            clear() {
                this.$refs.shipperSelect.value = 0;
                this.data = [];
            },
            fetchShipperNames(url, all = false) {
                axios.get(url)
                    .then(response => {
                        if (response.data.length > 0) {
                            if (all) {
                                this.allShippers = response.data.map(e => {
                                    return {shipper: (!_.isNil(e.shipper_name1) ? e.shipper_name1 :'') + ' ' + (!_.isNil(e.shipper_name2) ? e.shipper_name2 : ''), id: e.shipper_id};
                                });
                            } else {
                                this.shippers = response.data.map(e => {
                                    return {shipper: (!_.isNil(e.shipper_name1) ? e.shipper_name1 :'') + ' ' + (!_.isNil(e.shipper_name2) ? e.shipper_name2 : ''), id: e.shipper_id};
                                });
                            }
                        }
                    });
            },
            refresh() {
                this.editMode = false;
                this.clear();
                this.search();
            }
        }
    }
</script>
