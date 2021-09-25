<script>
/*
Memunculkan bubble box peringatan sebelum penghapusan
*/
    document.getElementById("konfirmasiHapusNota").addEventListener("click", function() {
        var deleteProperties = [{
            title: "Yakin ingin menghapus Nota ini?",
            yes: "Ya",
            no: "Batal",
            table: "nota",
            column: "id",
            columnValue: idNota,
            goBackNumber: -2,
            goBackStatement: "Daftar Nota"
        }];
    
        var deletePropertiesStringified = JSON.stringify(deleteProperties);
        showLightBoxGlobal(deletePropertiesStringified);
    });;
</script>