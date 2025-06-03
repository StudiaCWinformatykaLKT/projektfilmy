import { Head, Link, useForm } from '@inertiajs/react';
import { useEffect } from 'react';

export default function VerifyEmail({ status }) {
    const { post, processing } = useForm();

    const submit = (e) => {
        e.preventDefault();
        post(route('verification.send'));
    };

    return (
        <>
            <Head title="Verify Email" />
            <div className="bg-gradient-primary min-vh-100 d-flex align-items-center justify-content-center">
                <div className="container">
                    <div className="row justify-content-center">
                        <div className="col-xl-6 col-lg-6 col-md-6">
                            <div className="card o-hidden border-0 shadow-lg my-5">
                                <div className="card-body p-5">
                                    <div className="text-center">
                                        <h1 className="h4 text-gray-900 mb-4">Verify Your Email Address</h1>
                                        <p className="mb-4">
                                            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
                                            If you didn’t receive the email, we will gladly send you another.
                                        </p>
                                    </div>

                                    {status === 'verification-link-sent' && (
                                        <div className="alert alert-success mb-4 text-sm text-center" role="alert">
                                            A new verification link has been sent to your email address.
                                        </div>
                                    )}

                                    <form onSubmit={submit}>
                                        <div className="d-grid mb-3">
                                            <button
                                                type="submit"
                                                className="btn btn-primary btn-user btn-block"
                                                disabled={processing}
                                            >
                                                Resend Verification Email
                                            </button>
                                        </div>
                                    </form>

                                    <div className="text-center">
                                        <Link
                                            href={route('profile.edit')}
                                            className="small text-decoration-none"
                                        >
                                            Edit Profile
                                        </Link>
                                    </div>

                                    <div className="text-center mt-3">
                                        <form method="POST" action={route('logout')}>
                                            <button
                                                type="submit"
                                                className="btn btn-link small text-muted text-decoration-none"
                                            >
                                                Log Out
                                            </button>
                                        </form>
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
