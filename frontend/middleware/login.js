export default function ({ redirect, app }) {
  if (!app.$cookies.get('user_auth')) {
    return redirect('/')
  }
}
