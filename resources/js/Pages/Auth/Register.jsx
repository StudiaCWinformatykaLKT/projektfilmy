import { Head, Link, useForm } from '@inertiajs/react';

export default function Register() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('register'));
    };

    return (
        <>
            <Head title="Register" />
            <div className="bg-gradient-primary min-vh-100 d-flex align-items-center justify-content-center">
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-xl-6 col-lg-6 col-md-6">
                            <div className="card o-hidden border-0 shadow-lg my-5">
                                <div className="card-body p-5">
                                    <div className="text-center">
                                        <h1 className="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>
                                    <form className="user" onSubmit={submit}>
                                        <div className="form-group">
                                            <input
                                                type="text"
                                                className="form-control form-control-user"
                                                placeholder="Full Name"
                                                value={data.name}
                                                onChange={(e) => setData('name', e.target.value)}
                                                required
                                            />
                                            {errors.name && <div className="text-danger mt-1">{errors.name}</div>}
                                        </div>
                                        <div className="form-group">
                                            <input
                                                type="email"
                                                className="form-control form-control-user"
                                                placeholder="Email Address"
                                                value={data.email}
                                                onChange={(e) => setData('email', e.target.value)}
                                                required
                                            />
                                            {errors.email && <div className="text-danger mt-1">{errors.email}</div>}
                                        </div>
                                        <div className="form-group row">
                                            <div className="col-sm-6 mb-3 mb-sm-0">
                                                <input
                                                    type="password"
                                                    className="form-control form-control-user"
                                                    placeholder="Password"
                                                    value={data.password}
                                                    onChange={(e) => setData('password', e.target.value)}
                                                    required
                                                />
                                                {errors.password && <div className="text-danger mt-1">{errors.password}</div>}
                                            </div>
                                            <div className="col-sm-6">
                                                <input
                                                    type="password"
                                                    className="form-control form-control-user"
                                                    placeholder="Repeat Password"
                                                    value={data.password_confirmation}
                                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                                    required
                                                />
                                            </div>
                                        </div>
                                        <button
                                            type="submit"
                                            className="btn btn-primary btn-user btn-block"
                                            disabled={processing}
                                        >
                                            Register Account
                                        </button>
                                        <a href="/auth/google" className="btn btn-google btn-user btn-block">
                                            <i className="fab fa-google fa-fw"></i> Login with Google
                                        </a>

                                        <a href="/auth/facebook" className="btn btn-facebook btn-user btn-block">
                                            <i className="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>
                                    <hr />
                                    <div className="text-center">
                                        <Link href={route('login')} className="small">
                                            Already have an account? Login!
                                        </Link>
                                    </div>
                                    <div className="text-center mt-4">
                                        <img src="/img/kittylogo.jpg" alt="Kitty Movies" style={{ height: '80px' }} />
                                        <div className="small mt-1">Kitty Movies</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
