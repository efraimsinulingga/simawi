<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />        
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SIMAWI | Login </title>
        <link rel="icon" type="image/png" href="<?php echo base_url('public/assets/img/fav.png'); ?>" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@700&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="<?php echo base_url('public/css/styles.css') ?>" rel="stylesheet" />
        <link href="<?php echo base_url('public/css/custom.css') ?>" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>        
    </head>
    <body class="bg-ngurah-primary">        
        <div id="root">
        </div>

        <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
        <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
        <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

        <script type="text/babel">
            function LoginApp() {
                const [formInput, setFormInput] = React.useState({
                    email: '',
                    password: ''
                });

                const [formInputError, setFormInputError] = React.useState({
                    email: '',
                    password: ''
                });

                const [errorPage, setErrorPage] = React.useState('');
                const [loader, setLoader] = React.useState(false)
                const [showPassword, setShowPassword] = React.useState(false)

                const handleChange = (e) => {
                    const { name, value } = e.target;

                    setFormInput((prev) => ({
                        ...prev,
                        [name]: value,
                    }));

                    setFormInputError((prev) => ({
                        ...prev,
                        [name]: '',
                    }));
                };  

                const handleSubmit = async (e) => {
                    e.preventDefault();
                    setErrorPage('');
                    
                    const {errors, isValid} = validateForm(formInput);
                    setFormInputError(errors);
                    
                    if (isValid) {
                        setLoader((prev) => !prev)
                        try {    
                            const res = await fetch(`http://localhost:8080/auth/do_login`, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify(formInput),
                            });
                            
                            if (!res.ok) {
                                setErrorPage('Ada kesalahan di server. Coba beberapa saat lagi');
                            }

                            const data = await res.json();

                            if (data.code === "00") {
                                window.location.href='/'
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

                const validateForm = (form) => {                    
                    const errors = {
                        email: "",
                        password: "",
                    };
                    let isValid = true;

                    if (!form.email) {
                        errors.email = "Email wajib diisi";
                        isValid = false;
                    } else if (!/\S+@\S+\.\S+/.test(form.email)) {
                        errors.email = "Email tidak valid";
                        isValid = false;
                    }

                    if (!form.password) {
                        errors.password = "Password wajib diisi";
                        isValid = false;
                    } else if (form.password.length < 6) {
                        errors.password = "Password tidak boleh kurang dari 6 karakter";
                        isValid = false;
                    } else if (!/[A-Z]/.test(form.password)) {                        
                        errors.password = "Password harus memiliki uppercase karakter";
                        isValid = false;
                    } else if (!/[a-z]/.test(form.password)) {                        
                        errors.password = "Password harus memiliki minimal satu huruf";
                        isValid = false;
                    } else if (!/[^a-zA-Z]/.test(form.password)) {
                        errors.password =
                        "Password harus memiliki special character atau angka";
                        isValid = false;
                    }

                    return { errors, isValid };
                }

                const handleChangePassword = () => {
                    setShowPassword((prev) => !prev);
                };

                return (
                    <div id="layoutAuthentication">
                        <div id="layoutAuthentication_content">
                            <main>
                                <div className="container">
                                    <div className="row justify-content-center">
                                        <div className="col-lg-4">
                                            <div className="card shadow-lg border-0 rounded-lg mt-5">
                                                <div className="card-header bg-white text-center p-2">                                        
                                                    <img src="<?php echo base_url('public/assets/img/logo.png'); ?>" width="150"/>                                        
                                                </div>                                    
                                                <div className="card-body">
                                                    <h3 className="head-font m-0">SIMAWI</h3>
                                                    <p className="text-secondary">Login</p>
                                                    <form onSubmit={handleSubmit}>
                                                        <div className="form-floating mb-3 mt-3">
                                                            <input required name="email" onChange={handleChange} className="form-control" id="inputEmail" type="email" placeholder="name@example.com" autoFocus />
                                                            <label htmlFor="inputEmail">Alamat Email</label>
                                                        </div>
                                                        {formInputError.email != "" && (
                                                            <p className="small position-relative small-label text-danger">
                                                                <i className="fa-solid fa-circle-info"></i> {formInputError.email}
                                                            </p>
                                                        )}
                                                        
                                                        <div className="form-floating mb-3">
                                                            <input name="password" onChange={handleChange} className="form-control" id="inputPassword" type={!showPassword ? 'password' : 'text'} placeholder="Password" />
                                                            <label required htmlFor="inputPassword">Password</label>
                                                            <div className="toggle-pass position-absolute" onClick={handleChangePassword}>
                                                                <i className="fa-regular fa-eye text-secondary"></i>
                                                            </div>
                                                        </div>
                                                        {formInputError.password != "" && (
                                                            <p className="small position-relative small-label text-danger">
                                                                <i className="fa-solid fa-circle-info"></i> {formInputError.password}
                                                            </p>
                                                        )}                                                        
                                                        
                                                        <div className="mt-4 mb-2">
                                                            {errorPage != "" && (
                                                                <p className="small text-danger">
                                                                    <i className="fa-solid fa-circle-info"></i> {errorPage}
                                                                </p>
                                                            )}
                                                            <button disabled={loader} type="submit" className="w-100 btn btn-light bg-ngurah-secondary border-0 shadow-sm">
                                                                {
                                                                    !loader ? 
                                                                    ('LOGIN') : 
                                                                    (<svg
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
                                                                    </svg>)
                                                                }                                                                
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </main>
                        </div>            
                    </div>
                );
            }

            const root = ReactDOM.createRoot(document.getElementById("root"));
            root.render(<LoginApp />);
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('public/js/scripts.js'); ?>"></script>
    </body>
</html>
