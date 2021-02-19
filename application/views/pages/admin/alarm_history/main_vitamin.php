<script>
    let newDate = new Date();

    $(document).ready(function() {
        getTable();
        setInterval(function() {
            getTable();
        }, 1000);
    });

    function getTable() {
        $.ajax({
            url: '<?= site_url(); ?>alarmhistory/show',
            method: 'get',
            dataType: 'json',
            beforeSend: function() {
                //
            }
        }).always(function() {
            //
        }).fail(function(e) {
            console.log(e);
        }).done(function(e) {
            let datetime = new Date().toLocaleString('id-ID', {
                dateStyle: 'long',
                timeStyle: 'medium',
            });

            $('#current_datetime').html(datetime);

            if (e.data.length > 0) {
                let htmlnya = '';
                let no = 1;
                $.each(e.data, function(i, k) {
                    let color = (k.Al_Active == "1") ? "bg-danger" : "bg-success";
                    let area = "";

                    if (k.Al_Group == "1") {
                        area = "WWT-01";
                    } else if (k.Al_Group == "2") {
                        area = "WWT-02";
                    } else if (k.Al_Group == "3") {
                        area = "MIXBED";
                    } else if (k.Al_Group == "4") {
                        area = "DI-RO";
                    }
                    htmlnya += `
                    <tr>
                        <td class="${color} text-center">${no}</td>
                        <td class="${color} text-center">${k.Al_Event_Time}</td>
                        <td class="${color} text-center">${k.Al_Message}</td>
                        <td class="${color} text-center">${area}</td>
                    </tr>
                    `;

                    no++;
                });

                console.dir(htmlnya);
                $('#vresult').html(htmlnya);
            }
        });
    }
</script>