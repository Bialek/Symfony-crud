<?php 
    namespace App\Controller;

    use App\Entity\Reservation;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    class ReservationController extends Controller {
        /**
         * @Route("/", name="reservations_list")
         * @Method({"GET"})
         */
        public function index() {
            $reservations= $this->getDoctrine()->getRepository(Reservation::class)->findAll();

            return $this->render('reservation/index.html.twig', array('reservations' => $reservations));
        }
        /**
         * @Route("/reservation/{id}", name="reservation_show")
         */
        public function show($id) {
            $reservation = $this->getDoctrine()->getRepository(Reservation::class)->find($id);

            return $this->render('reservation/show.html.twig', array('reservation' => $reservation));
        }

        // /**
        //  * @Route("/reservation/save")
        //  */
        // public function save() {
        //     $entityManager = $this->getDoctrine()->getManager();

        //     $reservation = new Reservation;
        //     $reservation->setTitle('reservation 1');
        //     $reservation->setBody('This is the body for reservation 1');

        //     $entityManager->persist($reservation);

        //     $entityManager->flush();

        //     return new Response('save an reservation with the id of'.$reservation->getId());
        // }
    }