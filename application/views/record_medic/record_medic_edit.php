<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>SIMAWI - Data Pasien</title>
		<meta name="description" content="" />
		<?php $this->load->view('component/head', FALSE); ?>        
    </head>
    <body class="sb-nav-fixed">
		<?php $this->load->view('component/nav', FALSE); ?>
        <div id="layoutSidenav">
            <?php $this->load->view('component/sidebar', FALSE); ?>            
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h4 class="mt-4 head-font">Edit Pasien</h4>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('/'); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('/medical-record'); ?>">Riwayat Pasien</a></li>
                            <li class="breadcrumb-item active">Diagnosa</li>
                        </ol>                                           
                        
                        <hr>

                        <div id="root"></div>
                            
                    </div>
                </main>        
            </div>
        </div>

		<?php $this->load->view('component/footer', FALSE); ?>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
        <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
        <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
        <script>
            window.addEventListener('DOMContentLoaded', event => { 
                const datatablesSimple = document.getElementById('table');
                if (datatablesSimple) {
                    new simpleDatatables.DataTable(datatablesSimple);
                }
            });
        </script>
        <script type="text/babel">
            function LoginApp() {
                
                const [errorPage, setErrorPage] = React.useState('');
                const [loader, setLoader] = React.useState(false)
                const [q, setQ] = React.useState('')
                const [data, setData] = React.useState([])
                const [dataSelected, setDataSelected] = React.useState({})
                const formRef = React.useRef();

                const handleChange = (e) => {
                    const { name, value } = e.target;
                    setQ(value);       
                };

                React.useEffect(() => {
                if (dataSelected) {
                    console.log(dataSelected);
                }
                }, [dataSelected]);
                
                const handleSelected = (dataItem) => {
                    setDataSelected((prev) => dataItem)
                    document.getElementById('closeModal').click()
                };  

                const handleSubmitForm = (e) => {
                    e.preventDefault();
                    if(Object.keys(dataSelected).length === 0) {
                        setErrorPage('Maaf, data diagnose berdasarkan ICD harus diisi!');
                        return
                    }
                    formRef.current.submit()
                }

                const handleSubmit = async (e) => {
                    e.preventDefault();                        
                    setData([]);
                    setErrorPage('');                    
                    
                    if (q.length >= 3) {
                        setLoader(true)
                        try {
                            const res = await fetch(`<?php echo site_url('/icd?q=');?>${q}`, {
                                method: "GET",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                            });
                            
                            if (!res.ok) {
                                setErrorPage('Ada kesalahan di server. Coba beberapa saat lagi');
                            }

                            const data = await res.json();

                            if (data.code === "00") {
                                setData(data.data)
                                setLoader(false)
                            } else {
                                setErrorPage(data.message);
                                setLoader(false)
                            }
                            } catch (error) {
                                setLoader(false)
                                setErrorPage("Oops! Periksa koneksi internet Anda");
                            }
                        
                    }
                }
                

                return (                   
                    <div className="card mb-4">
                        <div className="card-header">
                            <div className="row">
                                <div className="col-md-8 pt-1">
                                    <i className="fas fa-stethoscope me-1"></i>
                                    Diagnosa
                                </div>                                    
                            </div>
                        </div>
                        <div className="card-body">
                            <form ref={formRef} action="<?php echo site_url('medical-record/diagnose-post')?>" method="POST" onSubmit={handleSubmitForm}>
                                <div className="row">
                                    <div className="col-md-4 col-12">
                                    <ul className="list-group list-group-flush">
                                        <li className="list-group-item"><?php echo $user->PatientName;?></li>
                                        <li className="list-group-item"><?php echo date('d M Y', strtotime($user->PatientBirth)); ?> (<?php echo (date('Y') - date('Y', strtotime($user->PatientBirth))); ?>thn)</li>
                                        <li className="list-group-item d-flex justify-content-between"><span><?php echo $user->PatientHeight;?>Cm</span><span className="text-secondary">Tinggi Badan</span></li>
                                        <li className="list-group-item d-flex justify-content-between"><span><?php echo $user->PatientWeight;?>Kg</span><span className="text-secondary">Berat Badan</span></li>
                                    </ul> 
                                    
                                        <div className="card mt-4">
                                            <div className="card-body">
                                                <div className="row">
                                                    <div className="col-md-8">
                                                        {Object.keys(dataSelected).length === 0 ?
                                                            (<p>Belum ada diagnosa ICD</p>)
                                                            :                                                            
                                                            (<>
                                                            <h5 className="head-font">{dataSelected.name}</h5>
                                                            <p className="text-secondary">{dataSelected.code}</p>
                                                            </>)
                                                            
                                                        }

                                                    </div>
                                                    <div className="col-md-4 text-end">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#modal" className="btn btn-light"><i className="fa-solid fa-magnifying-glass"></i> Cari</button>
                                                    </div>
                                                                                                        
                                                </div>                                                                             
                                            </div>    
                                        </div>    
                                    </div>
                                    <div className="col-md-8 col-12">    
                                        <input type="hidden" value="<?php echo $user->ID;?>" name="id"/>
                                        <input type="hidden" value={dataSelected.code} name="kode"/>
                                        <input type="hidden" value={dataSelected.name} name="name"/>
                                        <div className="form-group mb-2">
                                            <label className="text-secondary fs-6" htmlFor="symptoms">Gejala</label>
                                            <textarea name="symptoms" required className="form-control" placeholder="Isikan gejala" rows="4"></textarea>
                                        </div>

                                        <div className="form-group mb-2">                                                
                                            <label className="text-secondary fs-6" htmlFor="address">Diagnosa</label>
                                            <textarea name="diagnose" required className="form-control" placeholder="Hasil diagnosa dokter" rows="4"></textarea>
                                        </div>                                                                            

                                        {errorPage != "" && (
                                            <p className="small text-danger">
                                                <i className="fa-solid fa-circle-info"></i> {errorPage}
                                            </p>
                                        )}

                                        <button type="submit" className="btn btn-primary mt-3 float-end">SIMPAN</button>
                                    </div>
                                </div>
                            </form>
                            <div className="modal fade" id="modal" tabIndex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                <div className="modal-dialog modal-xl">
                                    <div className="modal-content">
                                    <div className="modal-header">
                                        <form className="w-100" onSubmit={handleSubmit}>
                                            <input onKeyPress={handleChange} name="q" className="form-control w-100 me-4" placeholder="Cari berdasarkan diagnosa, teken enter"/>
                                        </form>
                                        <button id="closeModal" type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div className="modal-body">
                                        <div className="">
                                        {loader &&
                                        <div className="text-center">
                                            <svg
                                                version="1.1"
                                                id="L4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                x="0px"
                                                y="0px"
                                                viewBox="0 0 100 100"
                                                enableBackground="new 0 0 100 100"
                                                style={{width:'32px'}}
                                            >
                                                <circle fill="#555" stroke="none" cx="20" cy="50" r="6">
                                                <animate
                                                    attributeName="opacity"
                                                    dur="1s"
                                                    values="0;1;0"
                                                    repeatCount="indefinite"
                                                    begin="0.1"
                                                />
                                                </circle>
                                                <circle fill="#555" stroke="none" cx="50" cy="50" r="6">
                                                <animate
                                                    attributeName="opacity"
                                                    dur="1s"
                                                    values="0;1;0"
                                                    repeatCount="indefinite"
                                                    begin="0.2"
                                                />
                                                </circle>
                                                <circle fill="#555" stroke="none" cx="80" cy="50" r="6">
                                                <animate
                                                    attributeName="opacity"
                                                    dur="1s"
                                                    values="0;1;0"
                                                    repeatCount="indefinite"
                                                    begin="0.3"
                                                />
                                                </circle>
                                            </svg>                                                            
                                        </div>
                                        }
                                        {data.length >=0 &&
                                        <ul className="list-group list-group-flush">                                                                
                                            {data.map((item, index) => {
                                                return (
                                                    <li key={index} className="list-group-item entity">
                                                        <div className="row">
                                                            <div className="col-md-8 head-font">{item.name}</div>
                                                            <div className="col-md-4 text-end text-secondary">
                                                                {item.code}
                                                                <button onClick={(e) => handleSelected(item)} type="button" className="btn btn-sm btn-light ms-2">Pilih</button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    );
                                            })}                                                                                                                                                                                                    
                                        </ul>
                                        }

                                        {(data.length <=0) && <p className="text-center text-secondary">Belum ada data yang ditampilkan, gunakan pencarian lain</p>}
                                        </div>
                                    </div>                                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                );
            }

            const root = ReactDOM.createRoot(document.getElementById("root"));
            root.render(<LoginApp />);
        </script>
    </body>
</html>
