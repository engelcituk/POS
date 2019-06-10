<script>
function addrowTarifa() {
    // $("#add_row").on("click", function () {
        // Dynamic Rows Code
        
        // Get max row id and set new id
        var newid = 0;
        $.each($("#tblMenuCartas tr"), function () {
            if (parseInt($(this).data("id")) > newid) {
                newid = parseInt($(this).data("id"));
            }
        });
        newid++;

        var tr = $("<tr></tr>", {
            id: "addr" + newid,
            "data-id": newid
        });

        // loop through each td and create new elements with name of newid
        $.each($("#tblMenuCartas tbody tr:nth(0) td"), function () {
            var cur_td = $(this);

            var children = cur_td.children();

            // add new td and element if it has a nane
            if ($(this).data("name") != undefined) {
                var td = $("<td></td>", {
                    "data-name": $(cur_td).data("name")
                });

                var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                var name = $(cur_td).data("name");

                c.attr("name", $(cur_td).data("name"));
                c.attr("id", $(cur_td).data("name") + newid);
                c.appendTo($(td));
                td.appendTo($(tr));
            } else {
                var td = $("<td></td>", {
                    'text': $('#tblMenuCartas tr').length
                }).appendTo($(tr));
            }
        });

        
       
        // add the new row
        $(tr).appendTo($('#tblMenuCartas'));
        //aplicamos select
        
        // $("#tipoServ" + newid + " option[value='1']").prop('selected', true);
        // $("#tipoRec" + newid + " option[value='1']").prop('selected', true);        

        $(tr).find("td button.row-remove").on("click", function () {
            $(this).closest("tr").remove();
        });
    // }); 

    // $("#add_row").trigger("click");
    
}
</script>
