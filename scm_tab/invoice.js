function RenderInvoice() {
    var userid = $('subcontractor_list').value;
    if (userid == '') {
        return;
    }

    replaceChildNodes('subcon_main', DIV({'id':'div_invoice'}, [
        DIV({'id': 'invoice_functions'}, [
            BUTTON({'id' : 'btn_refresh_list'}, 'Refresh List'),
            BUTTON({'id' : 'btn_create_draft'}, 'Create Draft'),
        ]),
        DIV({'id': 'invoice_list'}, [
            DIV({'id': 'container_draft_invoice'}, []),
            DIV(),
        ]),
        DIV({'class': 'clear'}, null),
    ]));

}
