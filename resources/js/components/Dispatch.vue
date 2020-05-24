<template>
    <div class="container dispatch">
        <div class="row">
            <div class="col-2">
                <a v-on:click="back"
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
        <dl class="badger-accordion js-badger-accordion">
            <dt class="badger-accordion__header">
                <button class="badger-accordion__trigger js-badger-accordion-header">
                    <div class="badger-accordion__trigger-title">
                        European Badgers - Meles meles
                    </div>
                    <div class="badger-accordion__trigger-icon">
                    </div>
                </button>
            </dt>
            <dd class="badger-accordion__panel js-badger-accordion-panel">
                <div class="badger-accordion__panel-inner text-module js-badger-accordion-panel-inner">
                    <p>Badgers are short-legged omnivores in the family Mustelidae, which also includes otters, polecats, weasels and wolverines. They belong to the caniform suborder of carnivoran mammals.</p>
                    <p>Badgers are thought to have got their name because of the white mark – or badge – on their head, although there are other theories.</p>
                    <p>Another old name for badgers is ‘brock’, meaning grey. You can often see the word brock in street names. Brock is also the name of a character in the Pokemon TV series!</p>
                    <p>Badgers are fast – they can run up to 30km per hour (nearly 20 mph) for short periods.</p>
                </div>
            </dd>
            <dt class="badger-accordion__header">
                <button class="badger-accordion__trigger js-badger-accordion-header">
                    <div class="badger-accordion__trigger-title">
                        Honey Badger - Mellivora capensis
                    </div>
                    <div class="badger-accordion__trigger-icon">
                    </div>
                </button>
            </dt>
            <dd class="badger-accordion__panel js-badger-accordion-panel">
                <div class="badger-accordion__panel-inner text-module js-badger-accordion-panel-inner">
                    <p>Honey badgers can reach 2.4 feet in length and weigh between 19 and 26 pounds. They have bushy tail that is usually 12 inches long.</p>
                    <p>Honey badger has incredible thick skin that cannot be pierced with arrows, spears or even machete. Skin is also very loose, which is useful in the case of attack. When predator grabs a badger, animal rotates in its skin and turns toward predator's face to fight back (attacking its eyes).</p>
                    <p>Honey badger has very sharp teeth. They can easily break tortoise shell.</p>
                </div>
            </dd>
            <dt class="badger-accordion__header">
                <button class="badger-accordion__trigger js-badger-accordion-header">
                    <div class="badger-accordion__trigger-title">
                        Hog Badger - Arctonyx collaris
                    </div>
                    <div class="badger-accordion__trigger-icon">
                    </div>
                </button>
            </dt>
            <dd class="badger-accordion__panel js-badger-accordion-panel">
                <div class="badger-accordion__panel-inner text-module js-badger-accordion-panel-inner">
                    <p>Although badgers are a solitary animal the young Hog Badger tends to be quite playful and social.  I would be careful playing with any animal that has extremely large claws.  Remember folks, it is all fun and games until someone loses an eye.</p>
                    <p>Hog Badgers are omnivores and they feed on a variety of things from honey and fruit to insects and small mammals. </p>
                    <p>A young / baby of a hog badger is called a 'kit'. The females are called 'sow' and males 'boar'. A hog badger group is called a 'cete, colony, set or company'.</p>
                </div>
            </dd>
        </dl>
    </div>

</template>
<script>
    import draggable from 'vuedraggable'
    import Datepicker from "vuejs-datepicker";
    import {en, ja} from 'vuejs-datepicker/dist/locale'
    import BadgerAccordion from "badger-accordion";

    export default{
        name: 'Dispatch',
        components: {
            draggable,
            Datepicker,
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
            add: function (evt, timezone) {
                this.change = true;
                let driver_id = evt.to.dataset.driverId;
                let postData = {
                    timezone: timezone,
                    item_id: evt.item.dataset.item_id,
                    driver_id: driver_id,
                };
                this.registerPostData.added.push(postData);
                $('.dispatch-table div[data-item_id='+postData.item_id+']').addClass('new');
            },
            register(){
                let componentInstance = this;
                if(this.registerPostData.added.length > 0 || this.registerPostData.removed.length > 0 ){
                    axios.post(this.registerUrl,this.registerPostData)
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
                    props: ['title','text','handle','button']
                }, {
                    button: button,
                    title: this.__('alert.message'),
                    text: '編集中のデータを破棄して前の画面に戻りますか？',
                    handle: function(button){
                        component.change = false;
                        if(button === 'back'){
                            window.location.href = component.backUrl;
                        }
                        if(button === 'display'){
                            component.fetchLists();
                        }
                        if(button === 'print'){
                            let date = component.dispatch_day_string;
                            window.location.href = this.pdfUrl + '?date=' + date;
                        }
                        if(button === 'nextDay'){
                            component.dispatch_day = component.getNextWorkday(new Date(component.dispatch_day), 1);
                            component.display();
                        }
                        if(button === 'nextTwoDay'){
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
            removeRow(id, elem){
                let index = this.tableDriverList.indexOf(elem.driver_id);
                if (index !== -1) this.tableDriverList.splice(index, 1);
                this.thirdList.splice(id, 1);
            },
            removeElem(item_id){
                let div = $('.dispatch-table div[data-item_id='+item_id+']');
                div.removeClass('new');
                let source = div.data('source');
                $('div.'+source).append(div);
                $('.dispatch-table div[data-item_id='+item_id+']').remove();
                this.thirdList.forEach(function (driver) {
                    driver.morning.forEach(function(item, index, arr){
                        if (item.item_id == item_id) {
                            arr.splice(index,1);
                        }
                    });
                    driver.noon.forEach(function(item, index, arr){
                        if (item.item_id == item_id) {
                            arr.splice(index,1);
                        }
                    });
                    driver.nextProduct.forEach(function(item, index, arr){
                        if (item.item_id == item_id) {
                            arr.splice(index,1);
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
                await axios.get(this.firstListUrl+'?date='+this.dispatch_day_string)
                    .then(result => {
                        this.firstList = _.cloneDeep(this.sanitizeLeftLists(result.data.first_list,'first'));
                    })
                    .catch(function (error) {
//                        console.log(error);
                        componentInstance.errorDialog(error);
                    });
            },
            fetchSecondList(date){
                let componentInstance = this;
                axios.get(this.secondListUrl+'?date='+date)
                    .then(result => {
                        this.secondList = _.cloneDeep(this.sanitizeLeftLists(result.data.second_list,'second'));
                    })
                    .catch(function (error) {
                        componentInstance.errorDialog(error);
                    });
            },
            fetchThirdList(){
                let componentInstance = this;
                axios.post(this.thirdListUrl,{'drivers':this.tableDriverList,'date':this.dispatch_day_string})
                    .then(result => {
                        this.thirdList = _.cloneDeep(this.sanitizeMainTable(result.data));
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
            new BadgerAccordion(".js-badger-accordion", {
                openMultiplePanels: true
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
