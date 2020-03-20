/**
 * Created by N0D1R on 19-Mar-20.
 */

module.exports = {

    data(){
        return {
            max1: {
                maxLength: [(args) => {
                    return args['value'].length <= 1;
                }, this.__('alert.at_most_1_letters')]
            },
            max4: {
                maxLength: [(args) => {
                    return args['value'].length <= 4;
                }, this.__('alert.at_most_4_letters')]
            },
            max5: {
                maxLength: [(args) => {
                    return args['value'].length <= 5;
                }, this.__('alert.at_most_5_letters')]
            },
            max8: {
                maxLength: [(args) => {
                    return args['value'].length <= 8;
                }, this.__('alert.at_most_8_letters')]
            },
            max10: {
                maxLength: [(args) => {
                    return args['value'].length <= 10;
                }, this.__('alert.at_most_10_letters')]
            },
            max12: {
                maxLength: [(args) => {
                    return args['value'].length <= 12;
                }, this.__('alert.at_most_12_letters')]
            },
            max13: {
                maxLength: [(args) => {
                    return args['value'].length <= 13;
                }, this.__('alert.at_most_13_letters')]
            },
            max60: {
                maxLength: [(args) => {
                    return args['value'].length <= 60;
                }, this.__('alert.at_most_60_letters')]
            },
            max120: {
                maxLength: [(args) => {
                    return args['value'].length <= 120;
                }, this.__('alert.at_most_120_letters')]
            },
            max255: {
                maxLength: [(args) => {
                    return args['value'].length <= 255;
                }, this.__('alert.at_most_255_letters')]
            },
        }

    }

};