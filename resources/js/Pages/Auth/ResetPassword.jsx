import { Head, Link, useForm } from '@inertiajs/react';

export default function ResetPassword({ token, email }) {
    const { data, setData, post, processing, errors } = useForm({
        token,
        email,
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('password.store'));
    };

    return (
        <>
            <Head title="Reset Password" />
            <div className="bg-gradient-primary min-vh-100 d-flex align-items-center justify-content-center">
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-xl-6 col-lg-6 col-md-6">
                            <div className="card o-hidden border-0 shadow-lg my-5">
                                <div className="card-body p-5">
                                    <div className="text-center">
                                        <h1 className="h4 text-gray-900 mb-4">Reset Your Password</h1>
                                    </div>
                                    <form className="user" onSubmit={submit}>
                                        <input type="hidden" name="token" value={data.token} />

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

                                        <div className="form-group">
                                            <input
                                                type="password"
                                                className="form-control form-control-user"
                                                placeholder="New Password"
                                                value={data.password}
                                                onChange={(e) => setData('password', e.target.value)}
                                                required
                                            />
                                            {errors.password && <div className="text-danger mt-1">{errors.password}</div>}
                                        </div>

                                        <div className="form-group">
                                            <input
                                                type="password"
                                                className="form-control form-control-user"
                                                placeholder="Confirm Password"
                                                value={data.password_confirmation}
                                                onChange={(e) => setData('password_confirmation', e.target.value)}
                                                required
                                            />
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
