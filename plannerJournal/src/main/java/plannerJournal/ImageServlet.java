package plannerJournal;
import java.io.IOException;
import java.io.OutputStream;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/code/getImage.jsp")
public class ImageServlet extends HttpServlet {
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
    	response.setContentType("image/png");
        if (request.getSession().getAttribute("user") == null) {
            response.sendRedirect("../pages/login.jsp");
            return;
        }

        String secretKey = request.getParameter("secretKey");
        String indexStr = request.getParameter("index");
        Image imagen = ImageHandler.downloadImage(secretKey, Integer.parseInt(indexStr));

        try (OutputStream fuera = response.getOutputStream()) {
            fuera.write(imagen.getBytes());
        }
    }
}
