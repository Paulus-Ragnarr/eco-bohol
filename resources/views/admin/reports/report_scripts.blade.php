<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="{{ asset('static/js/html2canvas.min.js') }}"></script>
<script>
    let printButton = document.getElementById('print-button');
    printButton.addEventListener('click', function() {
        html2canvas(document.getElementById('report-paper'), {
        useCORS: true,
    }).then(function(canvas) {

        window.jsPDF = window.jspdf.jsPDF;
        let width = canvas.width; 
        let height = canvas.height;

        //set the orientation
        if(width > height){
        pdf = new jsPDF('l', 'px', [width, height]);
        }
        else{
        pdf = new jsPDF('p', 'px', [height, width]);
        }
        //then we get the dimensions from the 'pdf' file itself
        width = pdf.internal.pageSize.getWidth();
        height = pdf.internal.pageSize.getHeight();
        pdf.addImage(canvas, 'PNG', 0, 0,width,height);
        pdf.save("report.pdf");
    })
    })
</script>