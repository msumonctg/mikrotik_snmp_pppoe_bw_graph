<!DOCTYPE html>
<html lang="en">
<title>Mikrotik SNMP BW</title>
    <head></head>
    <body>

        <div id="mycanvas">

            <div>
                <h4 v-if="snmpid == 'NA'">No Online SNMP ID Found For This PPPoE ID!</h4>
            </div>

            <div>
                <input type="text" v-model="nasip" placeholder="NAS IP">
                <input type="text" v-model="snmpcomstring" placeholder="SNMP Community String">
                <input type="text" v-model="pppoeid" placeholder="PPPoE User ID">
                <input type="text" v-model="snmpid" placeholder="SNMP ID(Auto-filled)" disabled>
                <input type="button" @click="getSnmpID" value="Generate Graph">
            </div>

            <br>

            <div>
                <canvas id="mycanvas1" width="400" height="100"></canvas>
                <h4 v-if="txmbps > 0.99">TX: {{txmbps}}Mbps</h4>
                <h4 v-if="txkbps > 0.99 && txmbps < 1">TX: {{txkbps}}Kbps</h4>
                <h4 v-if="txkbps < 1 && txmbps < 1">TX: {{txbps}}bps</h4>
            </div>

            <br>
            
            <div>
                <canvas id="mycanvas2" width="400" height="100"></canvas>
                <h4 v-if="rxmbps > 0.99">RX: {{rxmbps}}Mbps</h4>
                <h4 v-if="rxkbps > 0.99 && rxmbps < 1">RX: {{rxkbps}}Kbps</h4>
                <h4 v-if="rxkbps < 1 && rxmbps < 1">RX: {{rxbps}}bps</h4>
            </div>

        </div>

        <script src="axios.min.js"></script>
        <script src="vue.js"></script>

        <script type="text/javascript">

            var vm = new Vue({
            el: '#mycanvas',
            data () {
                return {
                    pppoeid: '',
                    snmpcomstring: '',
                    nasip: '',
                    snmpid: '',
                    rx1: '',
                    tx1: '',
                    rx2: '',
                    tx2: '',
                    rx: 0,
                    tx: 0,
                    rxbps: '',
                    txbps: '',
                    rxkbps: '',
                    txkbps: '',
                    rxmbps: '',
                    txmbps: '',
                    alertMsg: '',
                }
            },

            computed: {

            },

            watch: {

            },

            mounted () {
                // axios
                //     .get('mikrotikbw.shellapi.php?direction=tx')
                //     .then(response => (this.tx1 = response.data));
                // axios
                //     .get('mikrotikbw.shellapi.php?direction=rx')
                //     .then(response => (this.rx1 = response.data));
            },

            created () {
                setInterval(this.bwUsage, 1000);
            },

            methods: {
                bwUsage(){
                    if(this.snmpid !== '' && this.snmpid !== 'NA'){
                        axios
                        .get('mikrotikbw.shellapi.php?direction=tx&nasip='+this.nasip+'&snmpcomstring='+this.snmpcomstring+'&snmpid='+this.snmpid)
                            .then(response => (this.tx2 = response.data));
                        axios
                            .get('mikrotikbw.shellapi.php?direction=rx&nasip='+this.nasip+'&snmpcomstring='+this.snmpcomstring+'&snmpid='+this.snmpid)
                            .then(response => (this.rx2 = response.data));
                        if(this.tx1 == '' && this.rx1 == ''){
                            this.tx1 = this.tx2;
                            this.rx1 = this.rx2;
                            return 0;
                        }
                        else if(this.tx2 !== '' && this.rx2 !== '' && this.tx2 !== 'NA' && this.rx2 !== 'NA'){
                            this.txmbps = ((((this.tx2 - this.tx1)*8)/1024)/1024).toFixed(1);
                            this.rxmbps = ((((this.rx2 - this.rx1)*8)/1024)/1024).toFixed(1);
                            this.txkbps = (((this.tx2 - this.tx1)*8)/1024).toFixed(1);
                            this.rxkbps = (((this.rx2 - this.rx1)*8)/1024).toFixed(1);
                            this.txbps = ((this.tx2 - this.tx1)*8).toFixed(1);
                            this.rxbps = ((this.rx2 - this.rx1)*8).toFixed(1);
                            this.tx = (this.tx2 - this.tx1);
                            this.rx = (this.rx2 - this.rx1);
                            this.tx1 = this.tx2;
                            this.rx1 = this.rx2;
                        }
                    }
                },
                
                getSnmpID(){
                    this.reinitiateValues();
                    if(this.nasip !== '' && this.snmpcomstring !== '' && this.pppoeid !== ''){
                        axios
                        .get('mikrotiksnmpid.shellapi.php?nasip='+this.nasip+'&snmpcomstring='+this.snmpcomstring+'&pppoeid='+this.pppoeid)
                        .then(response => (this.snmpid = response.data));
                    }
                },

                reinitiateValues(){
                    this.snmpid = '';
                    this.tx = 0;
                    this.rx = 0;
                    this.tx1 = '';
                    this.rx1 = '';
                    this.txmbps = 0;
                    this.rxmbps = 0;
                    this.txkbps = 0;
                    this.rxkbps = 0;
                    this.txbps = 0;
                    this.rxbps = 0;
                },

                
            }
            })
        </script>




        <script type="text/javascript" src="smoothie.js"></script>

        <script>
            var smoothie1 = new SmoothieChart({
                grid: { strokeStyle:'rgb(125, 0, 0)', fillStyle:'rgb(60, 0, 0)',
                        lineWidth: 1, millisPerLine: 250, verticalSections: 6, },
                labels: { fillStyle:'rgb(60, 0, 0)' }
                });
            // Data
            var line1 = new TimeSeries();

            setInterval(function() {
            line1.append(new Date().getTime(), vm.tx);
            }, 1000);

            smoothie1.addTimeSeries(line1,
                { strokeStyle:'rgb(0, 255, 0)', fillStyle:'rgba(0, 255, 0, 0.4)', lineWidth:3 });


            smoothie1.streamTo(document.getElementById("mycanvas1"), 1000 /*delay*/); 
        </script>


        <script>
            var smoothie2 = new SmoothieChart({
                grid: { strokeStyle:'rgb(125, 0, 0)', fillStyle:'rgb(60, 0, 0)',
                        lineWidth: 1, millisPerLine: 250, verticalSections: 6, },
                labels: { fillStyle:'rgb(60, 0, 0)' }
                });
            // Data
            var line2 = new TimeSeries();

            setInterval(function() {    
            line2.append(new Date().getTime(), vm.rx);
            }, 1000);

            smoothie2.addTimeSeries(line2,
                { strokeStyle:'rgb(255, 0, 255)', fillStyle:'rgba(255, 0, 255, 0.3)', lineWidth:3 });


            smoothie2.streamTo(document.getElementById("mycanvas2"), 1000 /*delay*/); 
        </script>





    </body>
</html>