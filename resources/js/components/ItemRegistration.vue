<template>
    <div id="app">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-2">
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="register">Register</button>
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="clear">Clear</button>
            </div>
        </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-sm table-nowrap card-table">
                                <thead>
                                <tr></tr>
                                </thead>
                                <tbody class="list">
                                <tr>
                                    <td class="orders-order text-right"> <span class="c24966">Weekday</span></td>
                                    <td><select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select></td>
                                    <td class="text-right"><span class="c25479">Product Time</span></td>
                                    <td class="orders-product"><select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select> </td>
                                    <th><span class="c25479">:</span></th>
                                    <td class="orders-date"><select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select></td>
                                    <td class="orders-total"> <span class="c25479">Billing</span></td>
                                    <td class="orders-status"></td>
                                    <td class="orders-method"><label for="ordersSelectOne" class="custom-control-label">   </label></td>
                                    <td class="text-right">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="c24966">Later Date</span></td>
                                    <td class="orders-order"><select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select></td>
                                    <td class="orders-product text-right"> <span class="c25479 text-right">Drop time</span></td>
                                    <td class="orders-date"><select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select></td>
                                    <th><span class="c25479">:</span></th>
                                    <td class="orders-total"><select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select></td>
                                    <td class="orders-status">
                                        <div class="badge badge-success"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="c24966">Vehicle Model</span></td>
                                    <td class="orders-order"><select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select></td>
                                    <td class="orders-product"> </td>
                                    <td class="orders-date"></td>
                                    <td class="orders-total"> </td>
                                    <td class="orders-sratus">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="c24966">Shipper</span></td>
                                    <td class="orders-order"><select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select></td>
                                    <td class="orders-product"></td>
                                    <td class="orders-date"></td>
                                    <td class="orders-total"></td>
                                    <td class="orders-status">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="c24966">Loading Port</span></td>
                                    <td class="orders-order"><input type="text" placeholder="Default input" class="form-control" /></td>
                                    <td class="orders-product text-right"><span class="c25479 text-right">~  Drop off</span></td>
                                    <td class="orders-date"><input type="text" placeholder="Default input" class="form-control" /></td>
                                    <td class="orders-total"></td>
                                    <td class="orders-status">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="c24966">T numer</span></td>
                                    <td class="orders-order"><input type="text" placeholder="Default input" class="form-control" /></td>
                                    <td class="orders-product text-right"><span class="c25479 text-right">t     Empty PL</span></td>
                                    <td class="orders-date"><select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select></td>
                                    <td class="orders-total"></td>
                                    <td class="orders-status">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="c24966">Per ton</span></td>
                                    <td class="orders-order"> <input type="text" placeholder="Default input" class="form-control" /></td>
                                    <td class="orders-product"> <span class="c25479 text-right">yen     x</span></td>
                                    <td class="orders-date"><input type="text" placeholder="Default input" class="form-control" /></td>
                                    <td class="orders-total"><span class="c25479 text-right">t</span></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="c24966">Per vehicle</span></td>
                                    <td class="orders-order"><input type="text" placeholder="Default input" class="form-control" /></td>
                                    <td class="orders-product"><span class="c25479 text-right">yen     x</span></td>
                                    <td class="orders-date"><input type="text" placeholder="Default input" class="form-control" /></td>
                                    <td class="orders-total"></td>
                                    <td class="orders-sratus">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="c24966">Amount of Money</span></td>
                                    <td class="orders-order"><input type="text" placeholder="Default input" class="form-control" /></td>
                                    <td class="orders-product"><span class="c25479 text-right">yen</span></td>
                                    <td class="orders-date"></td>
                                    <td class="orders-total"></td>
                                    <td class="orders-status">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="c24966">Vehicle No.</span></td>
                                    <td class="orders-order"><input type="text" placeholder="Default input" class="form-control" /></td>
                                    <td class="orders-product text-right"><span class="c24966">Driver Name</span></td>
                                    <td class="orders-date"><select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select></td>
                                    <td class="orders-total"></td>
                                    <td class="orders-sratus">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="c24966">Chartered Vehicle</span></td>
                                    <td class="orders-order"><input type="text" placeholder="Default input" class="form-control" /></td>
                                    <td class="orders-product text-right"><span class="c24966">Rental Vehicle <br />Payment<br /></span></td>
                                    <td class="orders-date"><input type="text" placeholder="Default input" class="form-control" /></td>
                                    <td class="orders-total"><span class="c25479 text-right">yen</span></td>
                                    <td class="orders-sratus">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"><span class="c24966">Remarks</span></td>
                                    <td colspan="6" class="orders-order"><textarea rows="3" class="form-control"></textarea></td>
                                    <td class="orders-product"></td>
                                    <td class="orders-date"></td>
                                    <td class="orders-total"></td>
                                    <td class="orders-sratus">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
        },
        methods: {
            register(){
                alert('register action');
            },
            clear(){
                alert('clear action');
            },
        },
    }
</script>
