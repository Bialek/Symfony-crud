<?php 
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    // use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    class ReservationController extends Controller {
        /**
         * @Route("/")
         * @Method({"GET"})
         */
        public function index() {
            $reservations= ['Reservation 1', 'Reservation 2'];

            return $this->render('reservation/index.html.twig', array('reservations' => $reservations));
        }
    }