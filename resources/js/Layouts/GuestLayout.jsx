import { Link, usePage } from '@inertiajs/react';

export default function Navbar() {
    const { props } = usePage();
    const user = props.auth?.user;

    return (
        <nav className="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <ul className="navbar-nav ml-auto">
                {user ? (
                    <li className="nav-item dropdown no-arrow">
                        <a
                            className="nav-link dropdown-toggle"
                            href="#"
                            id="userDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <span className="mr-2 d-none d-lg-inline text-gray-600 small">
                                Witaj, {user.name}
                            </span>
                            <img className="img-profile rounded-circle" src="/img/avatar.png" style={{ height: '32px' }} />
                        </a>

                        <div className="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <Link className="dropdown-item" href={route('profile.edit')}>
                                <i className="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profil
                            </Link>
                            <div className="dropdown-divider"></div>
                            <Link href={route('logout')} method="post" as="button" className="dropdown-item">
                                <i className="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Wyloguj
                            </Link>
                        </div>
                    </li>
                ) : (
                    <li className="nav-item">
                        <Link href={route('login')} className="nav-link">
                            <span className="mr-2 text-gray-600 small">Zaloguj</span>
                            <img className="img-profile rounded-circle" src="/img/avatar.png" style={{ height: '32px' }} />
                        </Link>
                    </li>
                )}
            </ul>
        </nav>
    );
}
