/*

*  User: ovidiu.drumia

* Date: 06.03.2013

* Time: 10:06

*/

jQuery().ready(function() {

    jQuery('#source').change(appendInputFieldsOnSourceIpv6Change).change();

    jQuery('#destination').change(appendInputFieldsOnDestinationIpv6Change).change();

});

 

function appendInputFieldsOnSourceIpv6Change(){

    cleanSourceIpv6Address();

    if(jQuery('#source').val()=='HOST') {

        appendOctets('source');

    } else if (jQuery('#source').val()=='CIDR_PREFIX') {

        appendSourceCidr();

    }

}

 

function appendInputFieldsOnDestinationIpv6Change(){

    cleanDestinationIpv6Address();

    if(jQuery('#destination').val()=='HOST') {

        appendOctets('destination');

    }

}

 

function cleanSourceIpv6Address(){

    jQuery('#sourceIpv6Address').empty();

}

 

function cleanDestinationIpv6Address(){

    jQuery('#destinationIpv6Address').empty();

}

 

function appendOctets(prefix){

    jQuery('#' + prefix + 'Ipv6Address').append(jQuery('#ipAddress').val());

    for(var i=0; i<8; i++) {

        var octetID = '"' + prefix + 'Octet'+i+'"';

        jQuery('#' + prefix + 'Ipv6Address').append('<input id='+octetID+' name='+octetID+' type="text" maxlength="4" size="4" class="add_firewall"/>');

        if(i!=7) {

            jQuery('#' + prefix + 'Ipv6Address').append(':');

        }

    }

}

 

function appendSourceCidr() {

    jQuery('#sourceIpv6Address').append(jQuery('#ipAddress').val());

    jQuery('#sourceIpv6Address').append('<input id="sourceIpv6AddressCIDR" name="sourceIpv6AddressCIDR" type="text" maxlength="39" size="39" class="add_firewall"/>');

}

//sourceIpv6AddressCIDR
