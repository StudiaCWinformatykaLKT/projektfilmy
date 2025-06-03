import { Head, Link, useForm } from '@inertiajs/react';

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('login'));
    };


    return (
        <>
            <Head title="Login" />
            <div className="bg-gradient-primary min-vh-100 d-flex align-items-center justify-content-center">
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-lg-6">
                            <div className="card shadow-lg border-0 rounded-lg">
                                <div className="card-body p-5">
                                    <div className="text-center mb-4">
                                        <h4 className="text-gray-900">Welcome Back!</h4>
                                    </div>

                                    <form onSubmit={submit}>
                                        <div className="form-group">
                                            <input
                                                type="email"
                                                className="form-control form-control-user mb-3"
                                                placeholder="Enter Email Address..."
                                                value={data.email}
                                                onChange={(e) => setData('email', e.target.value)}
                                                required
                                            />
                                            {errors.email && <div className="text-danger">{errors.email}</div>}
                                        </div>

                                        <div className="form-group">
                                            <input
                                                type="password"
                                                className="form-control form-control-user mb-3"
                                                placeholder="Password"
                                                value={data.password}
                                                onChange={(e) => setData('password', e.target.value)}
                                                required
                                            />
                                            {errors.password && <div className="text-danger">{errors.password}</div>}
                                        </div>

                                        <div className="form-group form-check mb-3">
                                            <input
                                                type="checkbox"
                                                className="form-check-input"
                                                id="remember"
                                                checked={data.remember}
                                                onChange={(e) => setData('remember', e.target.checked)}
                                            />
                                            <label className="form-check-label" htmlFor="remember">
                                                Remember Me
                                            </label>
                                        </div>

                                        <button type="submit" className="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>

                                        <hr />

                                        <a href="/auth/google" className="btn btn-google btn-user btn-block">
                                            <i className="fab fa-google fa-fw"></i> Login with Google
                                        </a>

                                        <a href="/auth/facebook" className="btn btn-facebook btn-user btn-block">
                                            <i className="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>

                                    <hr />
                                    <div className="text-center">
                                        <Link href={route('password.request')} className="small">
                                            Forgot Password?
                                        </Link>
                                    </div>
                                    <div className="text-center">
                                        <Link href={route('register')} className="small">
                                            Create an Account!
                                        </Link>
                                    </div>
                                </div>
                            </div>

                            <div className="text-center mt-4">
                                <img src="/img/kittylogo.jpg" alt="Kitty Movies" style={{ height: '80px' }} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
