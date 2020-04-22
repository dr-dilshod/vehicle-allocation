<template>
    <div class="container dispatch">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div class="col-8">
                <h2 class="text-center">{{__('dispatch.dispatch_board')}}</h2>
            </div>
            <div class="col-2 text-right">
                <button id="registerBtn" @click="register" class="btn btn-lg btn-danger btn-fixed-width">
                    {{__('common.register')}}
                </button>
            </div>
        </div>
        <div class="row mt-2 mb-2">
            <div class="col-9 offset-1">
                <form action="#" @submit.prevent="display">
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group d-flex">
                                <label for="dispatch_day" class="mt-2">{{__('dispatch.dispatch_day')}}</label>&nbsp;&nbsp;&nbsp;
                                <datepicker v-model="dispatch_day" id="dispatch_day" name="dispatch_day" :bootstrap-styling="true"
                                            :format="options.weekday" :clear-button="true" :language="options.language.ja"
                                ></datepicker>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-fixed-width" id="display" @click.prevent="display">{{__('dispatch.display')}}</button>
                                <button type="button" class="btn btn-primary btn-fixed-width" id="nextDay" @click.prevent="nextDay">{{__('dispatch.next_day')}}</button>
                                <button type="button" class="btn btn-primary btn-fixed-width" id="twoDaysLater" @click.prevent="twoDaysLater">{{__('dispatch.two_days_later')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-2 text-right">
                <button id="printBtn" @click="print" class="btn btn-lg btn-success btn-fixed-width">{{__('dispatch.printing')}}</button>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="day1">
                <h6 class="text-center pt-1">
                    翌営業日 <br>
                    {{ firstList.formatDate }}
                </h6>
                <draggable :list="firstList.data" group="elems" class="first elem-list">
                    <div v-for="item in firstList.items" class="elem" :key="item.item_id" :data-item_id="item.item_id" :data-source="item.source">
                        <button type="button" class="close" @click="removeElem(item.item_id)"
                                aria-label="Close">
                            <span aria-hidden="true" class="text-danger">&times;</span>
                        </button>
                        <strong>{{ item.shipper_name }}</strong> <br>
                        {{ item.down_date }} {{ item.down_time }} <br>
                        {{ item.stack_point }} - {{ item.down_point }} <br>
                        {{ item.weight }}t <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span> <br>
                        {{__('dispatch.remarks')}}: {{ item.remarks }}<br>
                    </div>
                </draggable>
                </div>
                <div class="day2">
                <h6 class="text-center pt-1">
                    翌々営業日 <br>
                    {{ secondList.formatDate }}
                </h6>
                <draggable :list="secondList.data" group="elems" class="second elem-list">
                    <div v-for="item in secondList.items" class="elem" :key="item.item_id" :data-item_id="item.item_id" :data-source="item.source">
                        <button type="button" class="close" @click="removeElem(item.item_id)"
                                aria-label="Close">
                            <span aria-hidden="true" class="text-danger">&times;</span>
                        </button>
                        <strong>{{ item.shipper_name }}</strong> <br>
                        {{ item.down_date }} {{ item.down_time }} <br>
                        {{ item.stack_point }} - {{ item.down_point }} <br>
                        {{ item.weight }}t <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span> <br>
                        {{__('dispatch.remarks')}}: {{ item.remarks }}<br>
                    </div>
                </draggable>
                </div>
            </div>
            <div class="col-8">
                <div style="background: #fff;">
                    <table class="table">
                        <tr>
                            <td class="text-center">{{__('dispatch.car_no')}}</td>
                            <td class="text-center">{{__('dispatch.driver_name')}}</td>
                            <td style="width:170px" class="text-center">{{__('dispatch.morning')}}</td>
                            <td style="width:170px" class="text-center">{{__('dispatch.noon')}}</td>
                            <td style="width:170px" class="text-center">{{__('dispatch.next_product')}}</td>
                        </tr>
                    </table>
                    <div style="height: 380px; overflow-y: scroll; margin-top: -16.5px; border: 1px solid #ced4da; border-left: none; border-right: none;">
                        <table class="dispatch-table table" id="dispatchTable">
                            <tbody>
                            <tr v-for="(elem, idx) in thirdList" :key="elem.driver_id" :data-driver-id="elem.driver_id">
                                <td class="text-center">{{elem.vehicle_no}}</td>
                                <td class="text-center">
                                    <div class="driver">
                                        {{elem.driver_name}}
                                        <button type="button" class="close" @click="removeRow(idx, elem)" aria-label="Close">
                                            <span aria-hidden="true" class="text-danger">&times;</span>
                                        </button>
                                    </div>
                                </td>
                                <td style="width:170px">
                                    <draggable :list="elem.morning" group="elems" @add="add($event,1)" ghost-class="new"
                                               style="display: block; min-height: 50px" class="morning" :data-driver-id="elem.driver_id">
                                        <div class="elem" v-for="item in elem.morning" :key="item.item_id" :data-item_id="item.item_id">
                                            <button type="button" class="close" @click="removeElem(item.item_id)"
                                                    aria-label="Close">
                                                <span aria-hidden="true" class="text-danger">&times;</span>
                                            </button>
                                            <strong>{{ item.shipper_name }}</strong> <br>
                                            {{ item.down_date }} {{ item.down_time }} <br>
                                            {{ item.stack_point }} - {{ item.down_point }} <br>
                                            {{ item.weight }}t <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span> <br>
                                            {{__('dispatch.remarks')}}: {{ item.remarks }}<br>
                                        </div>
                                    </draggable>
                                </td>
                                <td style="width:170px">
                                    <draggable :list="elem.noon" group="elems" @add="add($event,2)" ghost-class="new"
                                               style="display: block; min-height: 50px" class="noon" :data-driver-id="elem.driver_id">
                                        <div class="elem" v-for="item in elem.noon" :key="item.item_id" :data-item_id="item.item_id">
                                            <button type="button" class="close" @click="removeElem(item.item_id)"
                                                    aria-label="Close">
                                                <span aria-hidden="true" class="text-danger">&times;</span>
                                            </button>
                                            <strong>{{ item.shipper_name }}</strong> <br>
                                            {{ item.down_date }} {{ item.down_time }} <br>
                                            {{ item.stack_point }} - {{ item.down_point }} <br>
                                            {{ item.weight }}t <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span> <br>
                                            {{__('dispatch.remarks')}}: {{ item.remarks }}<br>
                                        </div>
                                    </draggable>
                                </td>
                                <td style="width:170px">
                                    <draggable :list="elem.nextProduct" group="elems" @add="add($event,3)" ghost-class="new"
                                               style="display: block; min-height: 50px" class="next-product" :data-driver-id="elem.driver_id">
                                        <div class="elem" v-for="item in elem.nextProduct" :key="item.item_id" :data-item_id="item.item_id">
                                            <button type="button" class="close" @click="removeElem(item.item_id)"
                                                    aria-label="Close">
                                                <span aria-hidden="true" class="text-danger">&times;</span>
                                            </button>
                                            <strong>{{ item.shipper_name }}</strong> <br>
                                            {{ item.down_date }} {{ item.down_time }} <br>
                                            {{ item.stack_point }} - {{ item.down_point }} <br>
                                            {{ item.weight }}t <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span> <br>
                                            {{__('dispatch.remarks')}}: {{ item.remarks }}<br>
                                        </div>
                                    </draggable>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="padding: 10px">
                        <button data-toggle="modal" data-target="#addDriverModal" class="btn btn-primary btn-fixed-width">{{__('dispatch.add')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="addDriverModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title">{{__('dispatch.add_driver')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="form-group text-center d-flex justify-content-around">
                                <label for="driverName" class="pt-2">{{__('dispatch.driver_name')}}</label>
                                <input type="text" id="driverName" v-model="driver_search" class="form-control"
                                       style="width: calc(50%)"/>
                                <button class="btn btn-primary" @click="filterDrivers">{{__('common.search')}}</button>
                            </div>
                            <div class="driver-list">
                                <div class="row label-row mt-2 mr-2 ml-2 mb-0 pb-2">
                                    <div class="col-2"></div>
                                    <div class="col-4"><strong>{{__('dispatch.car_no')}}</strong></div>
                                    <div class="col-6"><strong>{{__('dispatch.driver_name')}}</strong></div>
                                </div>
                                <div class="driver-data">
                                    <label class="row m-2 label-row" v-for="driver in filtered_drivers">
                                        <div class="col-2 text-center">
                                            <input type="checkbox" v-model="tableDriverList" :value="driver.driver_id">
                                        </div>
                                        <div class="col-4">
                                            {{ driver.vehicle_no3 }}
                                        </div>
                                        <div class="col-6">
                                            {{ driver.driver_name }}
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <button type="button" class="btn btn-modal btn-danger btn-fixed-width" @click="registerDriver">{{__('common.register')}}</button>
                            <button type="button" class="btn btn-modal btn-warning ml-3 btn-fixed-width" data-dismiss="modal">{{__('dispatch.cancel')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import draggable from 'vuedraggable'
    import Datepicker from "vuejs-datepicker";
    import {en, ja} from 'vuejs-datepicker/dist/locale'

    export default{
        name: 'Dispatch',
        components: {
            draggable,
            Datepicker
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
                registerPostData: [],
                options: {
                    monthFormat: "yyyy/MM",
                    weekday: "yyyy/MM/dd",
                    language: {
                        en: en,
                        ja: ja
                    },
                },
            };
        },
        methods: {
            add: function (evt, timezone) {
//                console.log(evt);
                let driver_id = evt.to.dataset.driverId;
                let postData = {
                    timezone: timezone,
                    item_id: evt.item.dataset.item_id,
                    driver_id: driver_id,
                };
                this.registerPostData.push(postData);
                $('.dispatch-table div[data-item_id='+postData.item_id+']').addClass('new');
            },
            register(){
                let componentInstance = this;
                if(this.registerPostData.length > 0){
                    axios.post(this.registerUrl,this.registerPostData)
                    .then(response => {
                        componentInstance.registerPostData = [];
                        componentInstance.createSuccessDialog();
                        componentInstance.fetchLists();
                        componentInstance.clearNewClass();
                    });
                }
            },
            registerDriver(){
                let componentInstance = this;
                let data = {
                    date: this.firstList.date,
                    drivers: this.tableDriverList
                };
                axios.post(componentInstance.thirdListUrl,data)
                    .then(response => {
                        componentInstance.thirdList = this.sanitizeMainTable(response.data);
                        return true;
                    })
                    .catch(function(error){
                        componentInstance.errorDialog(error);
                    });
                $('#addDriverModal').modal('toggle');
            },
            clearNewClass(){
                $('.dispatch-table .elem').removeClass('new');
            },
            print(){
                let date = this.dispatch_day;
                window.location.href = this.pdfUrl + '?date=' + date;
            },
            display(){
                this.fetchLists();
            },
            nextDay(){
                this.dispatch_day = this.getNextWorkday(new Date(this.dispatch_day),1);
                this.display();
            },
            twoDaysLater(){
                this.dispatch_day = this.getNextWorkday(new Date(this.dispatch_day),2);
                this.display();
            },
            removeRow(id, elem){
                let index = this.tableDriverList.indexOf(elem.driver_id);
                if (index !== -1) this.tableDriverList.splice(index, 1);
                this.thirdList.splice(id, 1);
            },
            removeElem(item_id){
                console.log('first',this.firstList.items);
                console.log('second',this.secondList.items);
                let div = $('.dispatch-table div[data-item_id='+item_id+']');
                div.removeClass('new');
                let source = div.data('source');
                alert(source);
                $('div.'+source).append(div);
                $('.dispatch-table div[data-item_id='+item_id+']').remove();
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
                await axios.get(componentInstance.firstListUrl+'?date='+this.dispatch_day_string)
                    .then(result => {
                        componentInstance.firstList = this.sanitizeLeftLists(result.data.first_list,'first');
                    })
                    .catch(function (error) {
//                        console.log(error);
                        componentInstance.errorDialog(error);
                    });
            },
            fetchSecondList(date){
                let componentInstance = this;
                axios.get(componentInstance.secondListUrl+'?date='+date)
                    .then(result => {
                        componentInstance.secondList = this.sanitizeLeftLists(result.data.second_list,'second');
                    })
                    .catch(function (error) {
                        componentInstance.errorDialog(error);
                    });
            },
            fetchThirdList(){
                let componentInstance = this;
                axios.post(componentInstance.thirdListUrl,{'drivers':this.tableDriverList,'date':this.dispatch_day_string})
                    .then(result => {
                        componentInstance.thirdList = this.sanitizeMainTable(result.data);
                    })
                    .catch(function (error) {
                        componentInstance.errorDialog(error);
                    });
            },
            sanitizeLeftLists(array,source){
                array.items.forEach(function (elem) {
                    elem.down_time = (elem.down_time !== null) ? elem.down_time.slice(0,5) : '';
                    elem.down_date = elem.down_date.replace(/-/g,'/');
                    elem.source = source;
                });
                return array;
            },
            sanitizeMainTable(array){
                array.forEach(function (driver) {
                    driver.morning.forEach(function (elem) {
                        elem.down_time = (elem.down_time !== null) ? elem.down_time.slice(0,5) : '';
                        elem.down_date = elem.down_date.replace(/-/g,'/');
                    });
                    driver.noon.forEach(function (elem) {
                        elem.down_time = (elem.down_time !== null) ? elem.down_time.slice(0,5) : '';
                        elem.down_date = elem.down_date.replace(/-/g,'/');
                    });
                    driver.nextProduct.forEach(function (elem) {
                        elem.down_time = (elem.down_time !== null) ? elem.down_time.slice(0,5) : '';
                        elem.down_date = elem.down_date.replace(/-/g,'/');
                    });
                });
                return array;
            },
            getNextWorkday(d,days=1){
                d.setDate(d.getDate()+days); // tomorrow
                if (d.getDay() == 0) d.setDate(d.getDate()+1);
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
            axios.get(this.driverListUrl)
                .then(result => {
                    this.drivers = result.data.drivers;
                    this.filtered_drivers = result.data.drivers;
                    this.tableDriverList = result.data.tableDriverList;
                    this.display();
                })
                .catch(function (error) {
                    this.errorDialog(error);
                });
        },
        computed: {
            dispatch_day_string: function(){
                let date = this.dispatch_day;
                let dateString = '';
                if(typeof date === 'object')
                    dateString = date.getFullYear()+'/'+(date.getMonth()+1)+'/'+date.getDate();
                else
                    dateString = date;
                return dateString;
            }
        },
        watch: {
            registerPostData: function(){
                console.log('registerPostData=',this.registerPostData);
            },
        }
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
        font-size: 11px;
        width: 128px;
    }
    .dispatch .elem.new {
        background: #e2f0d9;
    }
    .dispatch .vdp-datepicker{
        display: inline-block;
    }
    .dispatch .elem-list {
        background: #fff;
        height: 440px;
        overflow-y: scroll;
    }
    .dispatch .day1, .day2{
        background-color: #fff;
        float: left;
        width: 155px;
    }
    .dispatch .day1 > div, .dispatch .day2 > div{
        border: 1px solid #ced4da;
    }
    .dispatch .label-row{
        border-bottom: 1px solid #ced4da;
    }
    .dispatch h6{
        font-size: 0.9rem;
    }
    .dispatch .dispatch-table{
        height: 440px;
        font-size: 12pt;
    }
</style>
