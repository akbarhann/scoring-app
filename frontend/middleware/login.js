export default function ({ redirect, app }) {
  if (!app.$cookies.get('user_auth')) {
    app.$cookies.set('user_auth', 'admin_dev', {
      path: '/',
      maxAge: 60 * 60 * 24 * 7,
    })
  }
}
