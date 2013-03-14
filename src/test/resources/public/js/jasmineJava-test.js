/**

* User: ovidiu.drumia

* Date: 06.03.2013

* Time: 10:06

*/

describe("ipv6FirewallRuleSourceAndDestinationSelectorCheangeTest", function() {

 

    var bddTest = true;

 

    beforeEach(function(){

        if(bddTest) {

            $('<form></form>').appendTo('body');

            $('<input type="hidden" id="ipAddress" value="Ip - Address"/>').appendTo('form');

            $('<select name="source" id="source" class="add_firewall"><option value="HOST"></option><option value="CIDR_PREFIX"></option><option value="ANY"></option></select>').appendTo('form');

            $('<ul><li id="sourceIpv6Address" class="genericListYellow01"></li></ul>').appendTo('form');

            $('<ul><li id="destinationIpv6Address" class="genericListYellow01"></li></ul>').appendTo('form');

            $('<select name="destination" id="destination" class="add_firewall"><option value="HOST"></option><option value="LAN"></option></select>').appendTo('form');

            jQuery('#source').change(appendInputFieldsOnSourceIpv6Change);

            jQuery('#destination').change(appendInputFieldsOnDestinationIpv6Change);

            bddTest = false;

        }

    });

 

    describe("When source 'HOST' selected 8 fields separated by : appear", function() {

        it("should append 8 input fields separated by : ", function() {

            jQuery('#source').change();

            expect($('#sourceIpv6Address')).toExist();

            // check sourceOctet${i} where i=0..7

            for(var i = 0; i < 8; i ++) {

                expect($('#sourceOctet' + i)).toExist();

            }

            expect($('#sourceIpv6Address')).toContainHtml("Ip - Address");

            expect($('#sourceIpv6Address').children().length).toEqual(8);

        });

    })

 

    describe("When source 'CIDR_PREFIX' selected 1 field appears", function() {

        it("should append 1 input field", function() {

            expect($('#sourceIpv6Address')).toExist();

            // select source value CIDR_PREFIX

            jQuery('#source').val('CIDR_PREFIX');

            jQuery('#source').change();

            // check sourceIpv6AddressCIDR

            expect($('#sourceIpv6Address')).toContainHtml("Ip - Address");

            expect($('#sourceIpv6AddressCIDR')).toExist();

            expect($('#sourceIpv6Address').children().length).toEqual(1);

        });

    })

 

    describe("When source 'ANY' no field appears", function() {

        it("no field appears", function() {

            expect($('#sourceIpv6Address')).toExist();

            // select source value ANY

            jQuery('#source').val('ANY');

            jQuery('#source').change();

            expect($('#sourceIpv6Address')).not.toContainHtml("Ip - Address");

            expect($('#sourceIpv6Address').children().length).toEqual(0);

        });

    })

 

    describe("When destination 'HOST' selected 8 fields separated by : appear", function() {

        it("should append 8 input fields separated by : ", function() {

            expect($('#destinationIpv6Address')).toExist();

            jQuery('#destination').change();

            // check sourceOctet${i} where i=0..7

            for(var i = 0; i < 8; i ++) {

                expect($('#destinationOctet' + i)).toExist();

            }

            expect($('#destinationIpv6Address')).toContainHtml("Ip - Address");

            expect($('#destinationIpv6Address').children().length).toEqual(8);

        });

    })

 

    describe("When destination 'LAN' no field appears", function() {

        it("no field appears", function() {

            expect($('#destinationIpv6Address')).toExist();

            // select source value LAN

            jQuery('#destination').val('LAN');

            jQuery('#destination').change();

            expect($('#destinationIpv6Address')).not.toContainHtml("Ip - Address");

            expect($('#destinationIpv6Address').children().length).toEqual(0);

        });

    })

});
