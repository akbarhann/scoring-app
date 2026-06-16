export default function ({ redirect, app }) {
  // Bypassed for development
  const isToken = true
  if (!isToken) {
    redirect({ name: 'index' })
  }
}
