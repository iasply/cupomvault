<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Redefinição de Senha</title>
</head>
<body style="margin:0; padding:0; background:#f5f5f5; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" style="padding: 40px 0;">

            <table width="600" cellpadding="0" cellspacing="0"
                   style="background:#ffffff; border-radius:10px; padding:30px; border:1px solid #ddd;">

                <tr>
                    <td style="font-size:22px; font-weight:bold; color:#333;">
                        Redefinição de Senha
                    </td>
                </tr>

                <tr>
                    <td style="padding-top:15px; font-size:15px; color:#555; line-height:1.6;">
                        Você solicitou a redefinição de senha da sua conta no Cupom Vault.
                        Clique no botão abaixo para continuar:
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding: 30px 0;">
                        <a href="{{ url('/cupomvault/senha/resetar/' . $token) }}"
                           style="background:#111; color:#fff; padding:14px 28px; text-decoration:none; border-radius:6px; display:inline-block;">
                            Redefinir Senha
                        </a>
                    </td>
                </tr>

                <tr>
                    <td style="font-size:14px; color:#666; line-height:1.6;">
                        Se você não solicitou esta alteração, basta ignorar esta mensagem.
                    </td>
                </tr>

                <tr>
                    <td style="padding-top:25px; font-size:14px; color:#444;">
                        Atenciosamente,<br>
                        <strong>Cupom Vault</strong>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
