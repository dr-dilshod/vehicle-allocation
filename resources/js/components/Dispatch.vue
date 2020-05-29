<template>
    <div class="container-fluid dispatch" style="padding-left: 15px; padding-right: 15px">
        <div class="d-flex">
            <div style="width: 20rem;">
                <a v-on:click="back"
                   class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div style="width: 20rem;">
                <h2 class="text-center">{{__('dispatch.dispatch_board')}}</h2>
            </div>
            <div style="width: 90rem;">
                <form action="#" @submit.prevent="display">
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group d-flex">
                                <label for="dispatch_day" class="mt-2">{{__('dispatch.dispatch_day')}}</label>&nbsp;&nbsp;&nbsp;
                                <datepicker v-model="dispatch_day" id="dispatch_day" :bootstrap-styling="true"
                                            :format="options.weekday" :clear-button="true"
                                            :language="options.language.ja"
                                ></datepicker>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-fixed-width" id="display"
                                        @click.prevent="display">{{__('dispatch.display')}}
                                </button>
                                <button type="button" class="btn btn-primary btn-fixed-width" id="nextDay"
                                        @click.prevent="nextDay">{{__('dispatch.next_day')}}
                                </button>
                                <button type="button" class="btn btn-primary btn-fixed-width" id="twoDaysLater"
                                        @click.prevent="twoDaysLater">{{__('dispatch.two_days_later')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div style="width: 40rem; text-align: right">
                <button id="printBtn" @click="print" class="btn btn-lg btn-success btn-fixed-width">
                    {{__('dispatch.printing')}}
                </button>
                <button id="registerBtn" @click="register" class="btn btn-lg btn-danger btn-fixed-width">
                    {{__('common.register')}}
                </button>
            </div>
        </div>
        <div class="d-flex">
            <div style="width: 15%; box-sizing: border-box">
                <div class="day1">
                    <h6 class="text-center pt-1">
                        翌営業日 <br>
                        {{ firstList.formatDate }}
                    </h6>
                    <draggable :list="firstList.data" group="elems" class="first elem-list">
                        <div v-for="item in firstList.items" class="elem" :key="item.item_id"
                             :data-item_id="item.item_id" :data-source="item.source">
                            <button type="button" class="close"
                                    @click="removeElem(item.item_id)"
                                    aria-label="Close">
                                                            <span aria-hidden="true"
                                                                  class="text-danger">&times;</span>
                            </button>
                            <strong>{{ item.shipper_name }}</strong>
                            {{ item.down_date }} <br>
                            {{ item.stack_point }} - {{ item.down_point }} <br>
                            <div class="hide">
                                <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span>
                                {{ item.item_remark }}
                            </div>
                        </div>
                    </draggable>
                </div>
            </div>
            <div style="width: 15%; box-sizing: border-box">
                <div class="day2">
                    <h6 class="text-center pt-1">
                        翌々営業日 <br>
                        {{ secondList.formatDate }}
                    </h6>
                    <draggable :list="secondList.data" group="elems" class="second elem-list">
                        <div v-for="item in secondList.items" class="elem" :key="item.item_id"
                             :data-item_id="item.item_id" :data-source="item.source">
                            <button type="button" class="close"
                                    @click="removeElem(item.item_id)"
                                    aria-label="Close">
                                                            <span aria-hidden="true"
                                                                  class="text-danger">&times;</span>
                            </button>
                            <strong>{{ item.shipper_name }}</strong>
                            {{ item.down_date }} <br>
                            {{ item.stack_point }} - {{ item.down_point }} <br>
                            <div class="hide">
                                <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span>
                                {{ item.item_remark }}
                            </div>
                        </div>
                    </draggable>
                </div>
            </div>
            <div style="width: 70%; box-sizing: border-box">
                <table class="table" style="margin-bottom: 0; border: 1px solid #ced4da">
                    <tr>
                        <td style="width: 12%" class="text-center">{{__('dispatch.car_no')}}</td>
                        <td style="width: 13%" class="text-center">{{__('dispatch.driver_name')}}</td>
                        <td style="width: 25%" class="text-center">{{__('dispatch.morning')}}</td>
                        <td style="width: 25%" class="text-center">{{__('dispatch.noon')}}</td>
                        <td style="width: 25%" class="text-center">{{__('dispatch.next_product')}}</td>
                    </tr>
                </table>
                <div style="background: #fff; border: 1px solid #ced4da;" class="mainTable">
                    <badger-accordion ref="myAccordion" :options="badgerOptions" :icons="icons">
                        <badger-accordion-item v-for="(entity, cc) in thirdList" :key="entity.type">
                            <template slot="header" style="background: lightskyblue; padding: 5px">
                                {{ entity.type }}
                            </template>
                            <template slot="content">
                                <div style="max-height: 380px; overflow-y: scroll; border: 1px solid #ced4da; border-left: none; border-right: none;">
                                    <table class="dispatch-table table">
                                        <tbody>
                                        <tr v-for="(elem, idx) in entity.items" :data-driver-id="elem.driver_id">
                                            <td style="width: 12%" class="text-center">{{elem.vehicle_no}}</td>
                                            <td style="width: 13%" class="text-center">
                                                <div class="driver d-flex">
                                                    <div class="name" style="width: 90%">
                                                        {{elem.driver_name}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 25%" >
                                                <draggable :list="elem.morning" group="elems" @add="add($event,1)"
                                                           ghost-class="new"
                                                           style="display: block; min-height: 50px" class="morning"
                                                           :data-driver-id="elem.driver_id">
                                                    <div class="elem" v-for="item in elem.morning"
                                                         :key="item.item_id" :data-item_id="item.item_id">
                                                        <button type="button" class="close"
                                                                @click="removeElem(item.item_id)"
                                                                aria-label="Close">
                                                            <span aria-hidden="true"
                                                                  class="text-danger">&times;</span>
                                                        </button>
                                                        <strong>{{ item.shipper_name }}</strong>
                                                        {{ item.down_date }} <br> <div class="hide">{{item.down_time}}</div>
                                                        {{ item.stack_point }} - {{ item.down_point }} <br>
                                                        <div class="hide">
                                                            <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span>
                                                            {{ item.item_remark }}
                                                        </div>
                                                    </div>
                                                </draggable>
                                            </td>
                                            <td style="width: 25%" >
                                                <draggable :list="elem.noon" group="elems" @add="add($event,2)"
                                                           ghost-class="new"
                                                           style="display: block; min-height: 50px" class="noon"
                                                           :data-driver-id="elem.driver_id">
                                                    <div class="elem" v-for="item in elem.noon" :key="item.item_id"
                                                         :data-item_id="item.item_id">
                                                        <button type="button" class="close"
                                                                @click="removeElem(item.item_id)"
                                                                aria-label="Close">
                                                            <span aria-hidden="true"
                                                                  class="text-danger">&times;</span>
                                                        </button>
                                                        <strong>{{ item.shipper_name }}</strong>
                                                        {{ item.down_date }} <br> <div class="hide">{{item.down_time}}</div>
                                                        {{ item.stack_point }} - {{ item.down_point }} <br>
                                                        <div class="hide">
                                                            <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span>
                                                            {{ item.item_remark }}
                                                        </div>
                                                    </div>
                                                </draggable>
                                            </td>
                                            <td style="width: 25%" >
                                                <draggable :list="elem.nextProduct" group="elems"
                                                           @add="add($event,3)" ghost-class="new"
                                                           style="display: block; min-height: 50px"
                                                           class="next-product" :data-driver-id="elem.driver_id">
                                                    <div class="elem" v-for="item in elem.nextProduct"
                                                         :key="item.item_id" :data-item_id="item.item_id">
                                                        <button type="button" class="close"
                                                                @click="removeElem(item.item_id)"
                                                                aria-label="Close">
                                                            <span aria-hidden="true"
                                                                  class="text-danger">&times;</span>
                                                        </button>
                                                        <strong>{{ item.shipper_name }}</strong>
                                                        {{ item.down_date }} <br> <div class="hide">{{item.down_time}}</div>
                                                        {{ item.stack_point }} - {{ item.down_point }} <br>
                                                        <div class="hide">
                                                            <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span>
                                                            {{ item.item_remark }}
                                                        </div>
                                                    </div>
                                                </draggable>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </template>
                        </badger-accordion-item>
                    </badger-accordion>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import draggable from 'vuedraggable'
    import Datepicker from "vuejs-datepicker";
    import {en, ja} from 'vuejs-datepicker/dist/locale'
    import {BadgerAccordion, BadgerAccordionItem} from 'vue-badger-accordion'

    export default{
        name: 'Dispatch',
        components: {
            draggable,
            Datepicker,
            BadgerAccordion,
            BadgerAccordionItem
        },
        props: {
            backUrl: {type: String, required: true},
            registerUrl: {type: String, required: true},
            firstListUrl: {type: String, required: true},
            secondListUrl: {type: String, required: true},
            thirdListUrl: {type: String, required: true},
            driverListUrl: {type: String, required: true},
            pdfUrl: {type: String, required: true},
        },
        data(){
            return {
                drivers: [],
                filtered_drivers: [],
                driver_search: '',
                tableDriverList: [],
                firstList: [],
                secondList: [],
                thirdList: [],
                dispatch_day: '',
                registerPostData: {
                    added: [],
                    removed: []
                },
                change: false,
                options: {
                    monthFormat: "yyyy/MM",
                    weekday: "yyyy/MM/dd",
                    language: {
                        en: en,
                        ja: ja
                    },
                },
                icons: {
                    opened: '<img src="./images/arrow_up16.png">',
                    closed: '<img src="./images/arrow_down16.png">'
                },
                badgerOptions: {
                    openHeadersOnLoad: [0],
                },
                timeout: 0,
            };
        },
        methods: {
            back() {
                if (this.change) {
                    this.confirm('back');
                } else {
                    window.location.href = this.backUrl;
                }
            },
            add(evt, timezone) {
                this.change = true;
                let driver_id = evt.to.dataset.driverId;
                let postData = {
                    timezone: timezone,
                    item_id: evt.item.dataset.item_id,
                    driver_id: driver_id,
                };
                this.registerPostData.added.push(postData);
                $('.dispatch-table div[data-item_id=' + postData.item_id + ']').addClass('new');
            },
            register(){
                let componentInstance = this;
                if (this.registerPostData.added.length > 0 || this.registerPostData.removed.length > 0) {
                    axios.post(this.registerUrl, this.registerPostData)
                        .then(response => {
                            componentInstance.registerPostData = [];
                            componentInstance.createSuccessDialog();
                            componentInstance.fetchLists();
                            componentInstance.clearNewClass();
                            componentInstance.change = false;
                            this.registerPostData = {
                                added: [],
                                removed: []
                            };
                        });
                }
            },
            registerDriver(){
                let componentInstance = this;
                axios.get(componentInstance.thirdListUrl+'?date='+this.firstList.date)
                    .then(response => {
//                        componentInstance.thirdList = this.sanitizeMainTable(response.data);
                        componentInstance.thirdList = response.data;
                        return true;
                    })
                    .catch(function (error) {
                        componentInstance.errorDialog(error);
                    });
            },
            clearNewClass(){
                $('.dispatch-table .elem').removeClass('new');
            },
            print(){
                if (this.change) {
                    this.confirm('print');
                } else {
                    let date = this.dispatch_day_string;
                    window.location.href = this.pdfUrl + '?date=' + date;
                }

            },
            confirm(button) {
                let component = this;
                this.$modal.show({
                    template: `
                        <div class="modal-content">
                            <div class="modal-header border-radius-0 bg-blue"><h5 class="modal-title">{{title}}</h5></div>
                            <div class="modal-body">
                                <div class="text-center p-5"><div v-html="text"></div></div>
                                <div class="text-center">
                                    <button class="btn btn-warning btn-fixed-width" @click="handle(button)">OK</button>
                                    <button class="btn btn-default btn-fixed-width" @click="$emit('close')">{{this.__('common.cancel')}}</button>
                                </div>
                            </div>
                        </div>
                      `,
                    props: ['title', 'text', 'handle', 'button']
                }, {
                    button: button,
                    title: this.__('alert.message'),
                    text: '編集中のデータを破棄して前の画面に戻りますか？',
                    handle: function (button) {
                        component.change = false;
                        if (button === 'back') {
                            window.location.href = component.backUrl;
                        }
                        if (button === 'display') {
                            component.fetchLists();
                        }
                        if (button === 'print') {
                            let date = component.dispatch_day_string;
                            window.location.href = this.pdfUrl + '?date=' + date;
                        }
                        if (button === 'nextDay') {
                            component.dispatch_day = component.getNextWorkday(new Date(component.dispatch_day), 1);
                            component.display();
                        }
                        if (button === 'nextTwoDay') {
                            component.dispatch_day = component.getNextWorkday(new Date(component.dispatch_day), 2);
                            component.display();
                        }
                        this.$emit('close');
                    }
                }, {
                    height: 'auto'
                });
            },
            display(){
                if (this.change) {
                    this.confirm('display');
                } else {
                    this.fetchLists();
                }
            },
            nextDay(){
                if (this.change) {
                    this.confirm('nextDay');
                } else {
                    this.dispatch_day = this.getNextWorkday(new Date(this.dispatch_day), 1);
                    this.display();
                }
            },
            twoDaysLater(){
                if (this.change) {
                    this.confirm('nextTwoDay');
                } else {
                    this.dispatch_day = this.getNextWorkday(new Date(this.dispatch_day), 2);
                    this.display();
                }
            },
            removeElem(item_id){
                let div = $('.dispatch-table div[data-item_id=' + item_id + ']');
                div.removeClass('new');
                let source = div.data('source');
                $('div.' + source).append(div);
                $('.dispatch-table div[data-item_id=' + item_id + ']').remove();
                this.thirdList.forEach(function (driver) {
                    driver.morning.forEach(function (item, index, arr) {
                        if (item.item_id == item_id) {
                            arr.splice(index, 1);
                        }
                    });
                    driver.noon.forEach(function (item, index, arr) {
                        if (item.item_id == item_id) {
                            arr.splice(index, 1);
                        }
                    });
                    driver.nextProduct.forEach(function (item, index, arr) {
                        if (item.item_id == item_id) {
                            arr.splice(index, 1);
                        }
                    });
                });
                this.registerPostData.removed.push(item_id);
                this.change = true;
            },
            fetchLists(){
                let component = this;
                this.fetchFirstList().then(function () {
                    component.fetchSecondList(component.firstList.date);
                });
                this.fetchThirdList();
            },
            async fetchFirstList(){
                let componentInstance = this;
                await axios.get(this.firstListUrl + '?date=' + this.dispatch_day_string)
                    .then(result => {
                        this.firstList = _.cloneDeep(this.sanitizeLeftLists(result.data.first_list, 'first'));
                    })
                    .catch(function (error) {
//                        console.log(error);
                        componentInstance.errorDialog(error);
                    });
            },
            fetchSecondList(date){
                let componentInstance = this;
                axios.get(this.secondListUrl + '?date=' + date)
                    .then(result => {
                        this.secondList = _.cloneDeep(this.sanitizeLeftLists(result.data.second_list, 'second'));
                    })
                    .catch(function (error) {
                        componentInstance.errorDialog(error);
                    });
            },
            fetchThirdList(){
                let componentInstance = this;
                axios.get(this.thirdListUrl+'?date='+ this.dispatch_day_string)
                    .then(result => {
                        this.thirdList = _.cloneDeep(this.sanitizeMainTable(result.data));
                    })
                    .catch(error => {
                        componentInstance.errorDialog(error);
                    });
            },
            sanitizeLeftLists(array, source){
                array.items.forEach(function (elem) {
                    elem.down_time = (elem.down_time !== null) ? elem.down_time.slice(0, 5) : '';
                    elem.down_date = elem.down_date.replace(/-/g, '/');
                    elem.source = source;
                });
                return array;
            },
            sanitizeMainTable(array){
                array.forEach(function (entity) {
                    entity.items.forEach(function (driver) {
                        driver.morning.forEach(function (elem) {
                            elem.down_time = (elem.down_time !== null) ? elem.down_time.slice(0, 5) : '';
                            elem.down_date = elem.down_date.replace(/-/g, '/');
                        });
                        driver.noon.forEach(function (elem) {
                            elem.down_time = (elem.down_time !== null) ? elem.down_time.slice(0, 5) : '';
                            elem.down_date = elem.down_date.replace(/-/g, '/');
                        });
                        driver.nextProduct.forEach(function (elem) {
                            elem.down_time = (elem.down_time !== null) ? elem.down_time.slice(0, 5) : '';
                            elem.down_date = elem.down_date.replace(/-/g, '/');
                        });
                    });
                });
                return array;
            },
            getNextWorkday(d, days = 1){
                d.setDate(d.getDate() + days); // tomorrow
                if (d.getDay() == 0) d.setDate(d.getDate() + 1);
                return d;
            },
            filterDrivers(){
                this.filtered_drivers = this.drivers.filter((driver) => {
                    return driver.driver_name.match(this.driver_search);
                });
            }
        },
        mounted(){
            this.dispatch_day = this.getNextWorkday(new Date());
            let component = this;
            axios.get(this.driverListUrl)
                .then(result => {
                    this.drivers = result.data.drivers;
                    this.filtered_drivers = result.data.drivers;
                    this.tableDriverList = result.data.tableDriverList;
                    this.display();
                })
                .catch(function (error) {
                    component.errorDialog(error);
                });
            let component = this;
            $('body').on('mouseover','.mainTable .elem',function (e) {
                let el = $(e.target);
                component.timeout = setTimeout(function () {
                    el.find('div.hide').each(function () {
                       $(this).removeClass('hide');
                    })
                }, 3000);
            }).on('mouseleave','.mainTable .elem', function (e) {
                clearTimeout(component.timeout);
                let el = $(e.target);
                el.find('div').each(function () {
                    $(this).addClass('hide');
                });
            });
        },
        computed: {
            dispatch_day_string: function () {
                let date = this.dispatch_day;
                let dateString = '';
                if (typeof date === 'object')
                    dateString = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                else
                    dateString = date;
                return dateString;
            }
        },

    }
</script>
<style scoped>
    .dispatch .table {
        background: #fff;
    }

    .dispatch .driver-list .driver-data {
        display: block;
        overflow-y: auto;
        overflow-x: hidden;
        height: 150px;
        width: 100%;
    }

    .dispatch .table th {
        vertical-align: middle;
    }

    .dispatch button.close {
        font-size: 16px;
        display: none;
    }

    .dispatch-table .driver:hover .close {
        display: inline;
    }

    .dispatch-table .elem:hover .close {
        display: inline;
    }

    .dispatch .elem {
        background: #dae3f3;
        border-radius: 10px;
        margin: 4px;
        padding: 7px;
        font-size: 14px;
    }

    .dispatch .elem.new {
        background: #e2f0d9;
    }

    .dispatch .vdp-datepicker {
        display: inline-block;
    }

    .dispatch .elem-list {
        background: #fff;
        height: 640px;
        overflow-y: scroll;
    }

    .dispatch .day1, .day2 {
        background-color: #fff;
        float: left;
        width: 14rem;
    }

    .dispatch .day1, .dispatch .day2 {
        border: 1px solid #ced4da;
    }

    .dispatch .day1 > div, .dispatch .day2 > div{
        border-top: 1px solid #ced4da;
    }

    .dispatch .label-row {
        border-bottom: 1px solid #ced4da;
    }

    .dispatch h6 {
        font-size: 0.9rem;
    }

    .dispatch .card-body{
        padding: 0;
    }

    .dispatch .dispatch-table {
        font-size: 12pt;
    }
    .dispatch .table th, .dispatch .table td{
        border-top: 0;
    }
    .dispatch .elem .close{
        width: 0.5rem;
        text-align: right;
    }
    .dispatch .hide{
        display: none;
    }
</style>
