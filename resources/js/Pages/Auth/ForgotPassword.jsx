import { Head, Link, useForm } from '@inertiajs/react';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('password.email'));
    };

    return (
        <>
            <Head title="Forgot Password" />
            <div className="bg-gradient-primary min-vh-100 d-flex align-items-center justify-content-center">
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-xl-6 col-lg-6 col-md-6">
                            <div className="card o-hidden border-0 shadow-lg my-5">
                                <div className="card-body p-5">
                                    <div className="text-center">
                                        <h1 className="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p className="mb-4">
                                            We get it, stuff happens. Just enter your email address below and we’ll send you a link to reset your password!
                                        </p>
                                    </div>

                                    {status && (
                                        <div className="alert alert-success text-sm mb-4" role="alert">
                                            {status}
                                        </div>
                                    )}

                                    <form className="user" onSubmit={submit}>
                                        <div className="form-group">
                                            <input
                                                type="email"
                                                className="form-control form-control-user"
                                                id="email"
                                                placeholder="Enter Email Address..."
                                                value={data.email}
                                                onChange={(e) => setData('email', e.target.value)}
                                                required
                                            />
                                            {errors.email && (
                                                <div className="text-danger mt-1">{errors.email}</div>
                                            )}
                                        </div>
                                        <button
                                            type="submit"
                                            className="btn btn-primary btn-user btn-block"
                                            disabled={processing}
                                        >
                                            Reset Password
                                        </button>
                                    </form>

                                    <hr />
                                    <div className="text-center">
                                        <Link href={route('login')} className="small">
                                            Back to Login
                                        </Link>
                                    </div>
                                    <div className="text-center">
                                        <Link href={route('register')} className="small">
                                            Create an Account!
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
